<?php

namespace App\Http\Controllers\Admin;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Review;
use App\Models\Notification;
use Codeboxr\PathaoCourier\Facade\PathaoCourier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $sql = Order::with('product', 'orderDetails')->orderBy('created_at', 'desc');

        if (isset($request->search)) {
            $sql->whereHas('product', function($q) use($request){
                $q->where('name', 'LIKE','%'.$request->search.'%');
            });
        }

        $orders = $sql->paginate(50);
        return view('admin.customer.orders', compact('orders'));
    }

    public function ordersView($id)
    {
        $order = Order::with('orderDetails', 'user', 'district', 'subDistrict')->where('id', $id)->orderBy('created_at', 'desc')->first();
        // $cities = PathaoCourier::area()->city();
        // return view('admin.customer.details', compact('order', 'cities'));
        return view('admin.customer.details', compact('order'));
    }

    public function dropshippingOrdersView ($id)
    {
        $order = Order::with('orderDetails', 'user', 'district', 'subDistrict')->where('id', $id)->orderBy('created_at', 'desc')->first();
        return view('admin.customer.dropshipping-details', compact('order'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $orderUpdate = Order::find($id);
        $orderUpdate->area = $request->area ? $request->area : 0;
        $orderUpdate->save();
        return response()->json($orderUpdate, 200);
    }

    public function orderPriceUpdate(Request $request, $id)
    {
        $orderDetailsPriceUpdate = OrderDetails::where('id', (int)$id)->first();
        $oldPrice = $orderDetailsPriceUpdate->price;
        $newPrice = $request->regular_price;
        $orderDetailsPriceUpdate->price = $newPrice;
        $orderDetailsPriceUpdate->save();

        $priceUpdate = Order::where('id', $orderDetailsPriceUpdate->order_id)->first();
        $priceUpdate->price = $priceUpdate->price - $oldPrice + $newPrice;
        $priceUpdate->save();
        return response()->json($priceUpdate, 200);
    }

    public function qtyUpdate(Request $request, $id)
    {
        $qtyUpdate = OrderDetails::find($id);
        $qtyUpdate->qty = $request->qty ? $qtyUpdate->qty + $request->qty : 0;
        $qtyUpdate->save();

        $orderQtyUpdate = Order::find($qtyUpdate->order_id);
        $orderQtyUpdate->qty = $orderQtyUpdate->qty + $request->qty;
        $orderQtyUpdate->save();

        return response()->json($qtyUpdate, 200);
    }

    //============== Order status ===============//

    public function pending($id)
    {
        $pending = OrderDetails::where('id', $id)->where('status', 0)->first();
        $pending->status = 1;
        $pending->save();

        if($pending->status == 1){
            $pendingOrder = Order::where('id', $pending->order_id)->first();
            $pendingOrder->status = 1;
            $pendingOrder->save();
        }
        return redirect()->back()->with('success', 'Order status has been changed.');
    }
    public function shipping($id)
    {
        $pending = OrderDetails::where('id', $id)->where('status', 1)->first();
        $pending->status = 2;
        $pending->save();

        if($pending->status == 2){
            $pendingOrder = Order::where('id', $pending->order_id)->first();
            $pendingOrder->status = 2;
            $pendingOrder->save();
        }
        return redirect()->back()->with('success', 'Order status has been changed.');
    }

    public function stocks()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.products.stocks', compact('products'));
    }

    public function ordersPdf($orderId)
    {
        $order = Order::with('orderDetails', 'user')->where('orderId', $orderId)->orderBy('created_at', 'desc')->first();

        $pdf = PDF::loadView('admin.pdf', compact('order'));

        return $pdf->stream('pdf_file.pdf');
    }

    public function pdf()
    {
        $data = [
            'title' => 'Welcome to shakil.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('admin.pdf', $data);

        return $pdf->download('banggomart.pdf');
    }

    public function processSelectedOrders (Request $request)
    {
        $selectedOrderIds = $request->id;
        if($selectedOrderIds==null){
            return redirect()->back()->with('error', 'Select Minimum One!');
        }

        //Code For Print or CSV Downloiad...
        $clickedButton = $request->input('submit_button');
        if ($clickedButton === 'print') {
            $selectedOrders = Order::with('orderDetails', 'admin')->whereIn('id', $selectedOrderIds)->get();

            //Update order_status as delivered...
            foreach ($selectedOrderIds as $orderId) {
                $order = Order::find($orderId);
                //dd($order);
                if ($order) {
                    $order->order_status = 'delivered';
                    $order->save();
                    //Notification...
                    $notification = new Notification();
                    $notification->message = 'Order with invoice id'.' '.$order->orderId.' '. 'is made status delivered by'.' '.Session::get('name');
                    $notification->specific_user_id = Session::get('id');
                    $notification->notification_for = "user";
                    $order->notification()->save($notification);
                    //Notification...
                }
            }
            //Update order_status as delivered...

            return view('admin.pdf', compact('selectedOrders'));
        }

        elseif ($clickedButton === 'csv') {
            $queryString = http_build_query($selectedOrderIds);
            return redirect()->route('download.orders.csv', ['id' => $queryString]);
        }
        //Code For Print or CSV Downloiad...

    }

    public function downloadCSV ($id)
    {
        $associativeArray = [];
        parse_str($id, $associativeArray);
        return Excel::download(new OrdersExport($associativeArray), 'orders.csv');

    }

    public function customerReview()
    {
        $productReviews = Review::with('product')->orderBy('id', 'desc')->get();
        return view('admin.customer.review', compact('productReviews'));
    }

    public function customerReviewForm()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.customer.review-create', compact('products'));
    }
    public function customerReviewEdit($id)
    {
        $products = Product::orderBy('id', 'desc')->get();
        $productReview = Review::with('product')->find($id);
        return view('admin.customer.review-edit', compact('products', 'productReview'));
    }

    public function customerReviewStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'product_id' => 'required',
            'rating' => 'required',
        ]);

        Review::create([
            'name' => $request->name,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
        ]);
        $this->setSuccessMessage('Customer review has been created');
        return redirect()->back();
    }
    public function customerReviewUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'product_id' => 'required',
            'rating' => 'required',
        ]);

        $review = Review::find($id);

        $review->update([
            'name' => $request->name,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
        ]);
        $this->setSuccessMessage('Customer review has been updated');
        return redirect()->back();
    }

    public function customerReviewDelete($id)
    {
        $review = Review::find($id);
        $review->delete();
        $this->setSuccessMessage('Customer review has been updated');
        return redirect()->back();
    }

    public function productColorUpdate(Request $request, $id)
    {
        $orderColorUpdate = OrderDetails::find($id);
        $orderColorUpdate->color = $request->color;
        $orderColorUpdate->save();
        return response()->json($orderColorUpdate, 200);
    }

    public function productSizeUpdate(Request $request, $id)
    {
        $orderSizeUpdate = OrderDetails::find($id);
        $orderSizeUpdate->size = $request->size;
        $orderSizeUpdate->save();
        return response()->json($orderSizeUpdate, 200);
    }

    //Pathao API...
    public function zoneList($cityId)
    {
        $zones = PathaoCourier::area()->zone($cityId);
        return response()->json(['zones' => $zones]);
    }
}
