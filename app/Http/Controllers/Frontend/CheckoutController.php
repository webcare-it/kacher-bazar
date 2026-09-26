<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Admin;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Models\Shipping;
use Exception;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $carts = Cart::with('product')->orWhere('user_id', auth()->check() ? Auth::guard('web')->user()->id : ' ')->orWhere('ip_address', request()->ip())->get();
        $comboProducts = RelatedProduct::with('products')->get();
        $cartTotal = $carts->sum('price');
        return view('frontend.v-2.checkout.checkout', compact('carts', 'comboProducts', 'cartTotal'));
    }

    public function customerOrderConfirm(OrderStoreRequest $request)
    {
        try {
        //===================== Order ======================//
        //Check the product is dropshipping...
        if(isset($request->id)){
            $productIdType = $request->id[0];
            $product = Product::find($productIdType);
            if (!$product) {
                return redirect('/')->with('error', 'Product not found!');
            }
        }
        else{
            return redirect('/')->with('error', 'No Products are choosen!');
        }
        $carts = Cart::with('product')->orWhere('user_id', auth()->check() ? Auth::guard('web')->user()->id : ' ')->orWhere('ip_address', request()->ip())->get();
        $cartsQty = Cart::with('product')->orWhere('user_id', auth()->check() ? Auth::guard('web')->user()->id : ' ')->orWhere('ip_address', request()->ip())->sum('qty');
        $cartsTotal = Cart::with('product')->orWhere('user_id', auth()->check() ? Auth::guard('web')->user()->id : ' ')->orWhere('ip_address', request()->ip())->sum('price');

        if ($carts->isEmpty()) {
            return redirect('/')->with('error', 'Your cart is empty!');
        }

        $totalQty = $cartsQty;
        $totalCost = $cartsTotal+$request->area;
        $order = new Order();
        //$order->user_id = auth('web')->user()->id;
        if($product->b_product_id == null){
            $order->is_dropshipping = false;
        }
        if($product->b_product_id != null){
            $order->is_dropshipping = true;
        }
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->area = $request->area;
        $order->district_id = $request->district_id;
        $order->sub_district_id = $request->sub_district_id;
        $order->address = $request->address;
        $order->notes = $request->notes;
        $order->orderId = $order->invoiceNumber();
        $order->price = $totalCost;
        $order->qty = $totalQty;
        $order->payment_type = $request->payment_type;

        $order->order_type = $request->order_type;

        $customerCheck = Order::where('phone', $request->phone)->first();

        $order->customer_type = $customerCheck ? 'Old Customer' : 'New Customer';

        //Assign to employee
        $users = Admin::where('name', '!=', 'admin')->where('is_active', '!=', 0)
        ->whereDate('limit_updated_at', '!=', \Illuminate\Support\Carbon::today())->get();
        //dd($users);
        if($users->isEmpty()){
            $admin = Admin::first();
            $order->employee_id = $admin->id;
        }
        $session_user = Session::get('id');
        if($session_user != null && session('name') != 'admin'){
            $order->employee_id = $session_user;
        }
        if($users->isNotEmpty() && $session_user == null){
            $randomUserId = $users->random()->id;
            $order->employee_id = $randomUserId;

            $assigned_employee = Admin::find($randomUserId);
            $assigned_employee_order = Order::where('employee_id', $assigned_employee->id)->whereDate('created_at', \Illuminate\Support\Carbon::today())->count();
            if($assigned_employee_order >= $assigned_employee->order_limit){
                $assigned_employee->is_limit = true;
                $assigned_employee->limit_updated_at = now();
                $assigned_employee->save();
            }
            else{
                $assigned_employee->is_limit = false;
                $assigned_employee->save();
            }
        }
        //Assign to employee

        $order->save();

        //===================== Order details ======================//

        if(!empty($order)){
            foreach($carts as $cart){
                $productOrder = new OrderDetails();
                $productOrder->order_id = $order->id;
                $productOrder->product_id = $cart->product_id;
                // $productOrder->qty = $request->qty[$key];
                $productOrder->qty = $cart->qty;
                // $productOrder->price = $request->total[$key];
                $productOrder->price = $cart->price;
                $productOrder->size = $cart->size;
                $productOrder->color = $cart->color;
                $productOrder->save();

                $productsQty = Product::where('id', $cart->product_id)->get();
                foreach ($productsQty as $qty){
                    $qty->qty = $qty->qty - $cart->qty;
                    $qty->save();
                }
            }
        }


        //===================== User cart product delete ======================//
        if(!empty($order)){
            $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
            foreach($cartProduct as $product){
                $product->delete();
            }
        }
        $this->setSuccessMessage('Your order has been successfully submitted. Thank you for connecting us.');
        if($request->order_type == 'Website'){
            return redirect('/order-received/'.$order->orderId);
        }
        else{
            return redirect('/admin/dashboard');
        }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function customerOrderConfirmManual(OrderStoreRequest $request)
    {
        try {
        //===================== Order ======================//
        //Check the product is dropshipping...
        if(isset($request->id)){
            $productIdType = $request->id[0];
            $product = Product::find($productIdType);
            if (!$product) {
                return redirect('/')->with('error', 'Product not found!');
            }
        }
        else{
            return redirect('/')->with('error', 'No Products are choosen!');
        }

        $totalQty = array_sum($request->indqty);
        $totalCost = array_sum($request->indprice1)+$request->area;
        $order = new Order();
        //$order->user_id = auth('web')->user()->id;
        if($product->b_product_id == null){
            $order->is_dropshipping = false;
        }
        if($product->b_product_id != null){
            $order->is_dropshipping = true;
        }
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->area = $request->area;
        $order->district_id = $request->district_id;
        $order->sub_district_id = $request->sub_district_id;
        $order->address = $request->address;
        $order->orderId = $order->invoiceNumber();
        $order->price = $totalCost;
        $order->qty = $totalQty;
        $order->payment_type = $request->payment_type;

        $order->order_type = $request->order_type;

        $customerCheck = Order::where('phone', $request->phone)->first();

        $order->customer_type = $customerCheck ? 'Old Customer' : 'New Customer';

        //Assign to employee
        $users = Admin::where('name', '!=', 'admin')->where('is_active', '!=', 0)
            ->whereDate('limit_updated_at', '!=', \Illuminate\Support\Carbon::today())->get();
        //dd($users);
        if($users->isEmpty()){
            $admin = Admin::first();
            $order->employee_id = $admin->id;
        }
        $session_user = Session::get('id');
        if($session_user != null && session('name') != 'admin'){
            $order->employee_id = $session_user;
        }
        if($users->isNotEmpty() && $session_user == null){
            $randomUserId = $users->random()->id;
            $order->employee_id = $randomUserId;

            $assigned_employee = Admin::find($randomUserId);
            $assigned_employee_order = Order::where('employee_id', $assigned_employee->id)->whereDate('created_at', \Illuminate\Support\Carbon::today())->count();
            if($assigned_employee_order >= $assigned_employee->order_limit){
                $assigned_employee->is_limit = true;
                $assigned_employee->limit_updated_at = now();
                $assigned_employee->save();
            }
            else{
                $assigned_employee->is_limit = false;
                $assigned_employee->save();
            }
        }
        //Assign to employee

        $order->save();

        //===================== Order details ======================//

        if(!empty($order)){
            foreach($request->id as $key => $product){
                $productOrder = new OrderDetails();
                $productOrder->order_id = $order->id;
                $productOrder->product_id = $request->id[$key];
                // $productOrder->qty = $request->qty[$key];
                $productOrder->qty = $request->indqty[$key];
                // $productOrder->price = $request->total[$key];
                $productOrder->price = $request->indprice[$key];
                $productOrder->size = $request->size[$key];
                $productOrder->color = $request->color[$key];
                $productOrder->save();
            }
        }

        //===================== Product qty update  ======================//
        $productsQty = Product::where('id', $request->id)->get();
        foreach ($productsQty as $k => $qty){
            $qty->qty = $qty->qty - $request->qty[$k];
            $qty->save();
        }


        //===================== User cart product delete ======================//
        if(!empty($order)){
            $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
            foreach($cartProduct as $product){
                $product->delete();
            }
        }
        $this->setSuccessMessage('Your order has been successfully submitted. Thank you for connecting us.');
        if($request->order_type == 'Website'){
            return redirect('/order-received/'.$order->orderId);
        }
        else{
            return redirect('/admin/dashboard');
        }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function customerOrderThankyou ($order_id)
    {
        $order_details = Order::where('orderId', $order_id)->first();
        return view('frontend.v-2.checkout.thankyou', compact('order_details'));
    }

    public function customer_checkout(CheckoutRequest $request)
    {
        try{
            $billing = new Billing();
            $billing->user_id = auth('web')->user()->id;
            $billing->first_name = $request->first_name;
            $billing->last_name = $request->last_name;
            $billing->email = $request->email;
            $billing->phone = $request->phone;
            $billing->country_name = $request->country_name;
            $billing->city_name = $request->city_name;
            $billing->distric_name = $request->distric_name;
            $billing->zip = $request->zip;
            $billing->address = $request->address;
            $billing->save();

            //Shipping information
            $shipping = new Shipping();
            $shipping->user_id = auth('web')->user()->id;
            $shipping->first_name = $request->first_name;
            $shipping->last_name = $request->last_name;
            $shipping->email = $request->email;
            $shipping->phone = $request->phone;
            $shipping->country_name = $request->country_name;
            $shipping->city_name = $request->city_name;
            $shipping->distric_name = $request->distric_name;
            $shipping->zip = $request->zip;
            $shipping->address = $request->address;
            $shipping->save();
            return redirect('/payment')->with('success', 'Your billing and shipping information has been submited.');
        }catch(Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function payment_form()
    {
        $products = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
        return view('frontend.checkout.payment', compact('products'));
    }

    public function customerPayment(Request $request)
    {
        //dd($request->all());
//        $this->validate($request, [
//            'vendor_id' => 'required',
//            'price' => 'required',
//            'qty' => 'required|integer',
//        ]);



        //===================== Product stock update ======================//
//        $productStockUpdate = Product::where('id', $request->order_product_id)->get();
//        foreach($productStockUpdate as $key => $stock){
//            $stock->stock = $stock->stock - $request->order_qty[$key];
//            $stock->save();
//        }
//
//        if($request->bkash){
//            $payment = new Payment();
//            $payment->user_id = auth('web')->user()->id;
//            $payment->payment_type = $request->bkash;
//            $payment->transaction_id = $request->transaction_id;
//            $payment->total_pay = $request->total_pay;
//            $payment->save();
//
//            //===================== Order ======================//
//
//            $order = new Order();
//            $order->user_id = auth('web')->user()->id;
//            $order->orderId = random_int(10000, 99999);
//            $order->price = $request->total_pay;
//            $order->save();
//
//            //===================== Order details ======================//
//
//            if(!empty($payment)){
//                foreach($request->order_product_id as $key => $product){
//                    $productOrder = new OrderDetails();
//                    $productOrder->order_id = $order->id;
//                    $productOrder->vendor_id = $request->vendor_id[$key];
//                    $productOrder->product_id = $request->order_product_id[$key];
//                    $productOrder->qty = $request->order_qty[$key];
//                    $productOrder->price = $request->regular_price[$key];
//                    $productOrder->save();
//                }
//            }
//
//            //===================== User cart product delete ======================//
//            if(!empty($payment)){
//                $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
//                foreach($cartProduct as $product){
//                    $product->delete();
//                }
//            }
//        }
//        elseif($request->nogad){
//            $payment = new Payment();
//            $payment->user_id = auth('web')->user()->id;
//            $payment->payment_type = $request->nogad;
//            $payment->transaction_id = $request->transaction_id;
//            $payment->total_pay = $request->total_pay;
//            $payment->save();
//
//            //===================== Order ======================//
//
//            $order = new Order();
//            $order->user_id = auth('web')->user()->id;
//            $order->orderId = random_int(10000, 99999);
//            $order->price = $request->total_pay;
//            $order->save();
//
//            //===================== Order details ======================//
//
//            if(!empty($payment)){
//                foreach($request->order_product_id as $key => $product){
//                    $productOrder = new OrderDetails();
//                    $productOrder->order_id = $order->id;
//                    $productOrder->vendor_id = $request->vendor_id[$key];
//                    $productOrder->product_id = $request->order_product_id[$key];
//                    $productOrder->qty = $request->order_qty[$key];
//                    $productOrder->price = $request->regular_price[$key];
//                    $productOrder->save();
//                }
//            }
//
//            //===================== User cart product delete ======================//
//            if(!empty($payment)){
//                $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
//                foreach($cartProduct as $product){
//                    $product->delete();
//                }
//            }
//        }
//        elseif($request->rocket){
//            $payment = new Payment();
//            $payment->user_id = auth('web')->user()->id;
//            $payment->payment_type = $request->rocket;
//            $payment->transaction_id = $request->transaction_id;
//            $payment->total_pay = $request->total_pay;
//            $payment->save();
//
//            //===================== Order ======================//
//
//            $order = new Order();
//            $order->user_id = auth('web')->user()->id;
//            $order->orderId = random_int(10000, 99999);
//            $order->price = $request->total_pay;
//            $order->save();
//
//            //===================== Order details ======================//
//
//            if(!empty($payment)){
//                foreach($request->order_product_id as $key => $product){
//                    $productOrder = new OrderDetails();
//                    $productOrder->order_id = $order->id;
//                    $productOrder->vendor_id = $request->vendor_id[$key];
//                    $productOrder->product_id = $request->order_product_id[$key];
//                    $productOrder->qty = $request->order_qty[$key];
//                    $productOrder->price = $request->regular_price[$key];
//                    $productOrder->save();
//                }
//            }
//
//            //===================== User cart product delete ======================//
//            if(!empty($payment)){
//                $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
//                foreach($cartProduct as $product){
//                    $product->delete();
//                }
//            }
//        }
//        else{
//
//
//        }

//        $payment = new Payment();
//        $payment->user_id = auth('web')->user()->id;
//        $payment->payment_type = $request->cod;
//        $payment->transaction_id = 'cash on delivery';
//        $payment->total_pay = $request->total_pay;
//        $payment->save();

        //===================== Order ======================//

        $order = new Order();
        $order->user_id = auth('web')->user()->id;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->area = $request->area;
        $order->district_id = $request->district_id;
        $order->sub_district_id = $request->sub_district_id;
        $order->address = $request->address;
        $order->orderId = $order->invoiceNumber();
        $order->price = $request->totalCost;
        $order->save();

        //===================== Order details ======================//

        if(!empty($order)){
            foreach($request->id as $key => $product){
                $productOrder = new OrderDetails();
                $productOrder->order_id = $order->id;
                $productOrder->vendor_id = $request->vendor_id[$key];
                $productOrder->product_id = $request->id[$key];
                $productOrder->qty = $request->qty[$key];
                $productOrder->price = $request->total[$key];
                $productOrder->save();
            }
        }


        //===================== User cart product delete ======================//
        if(!empty($payment)){
            $cartProduct = Cart::orWhere('user_id', auth()->guard('web')->check() ? auth('web')->user()->id : '')->orWhere('ip_address', request()->ip())->get();
            foreach($cartProduct as $product){
                $product->delete();
            }
        }

        return redirect('/order/complete')->with('success', 'Your order has been successfully submitted. Thank you for connecting us.');
    }

    public function completeOrder()
    {
        return view('frontend.order.complete');
    }

        public function cartProductDelete($id): \Illuminate\Http\RedirectResponse
    {
        $cartProduct = Cart::find($id);
        $cartProduct->delete();
        return redirect()->back()->with('success', 'Your cart product has been deleted.');
    }
}
