<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Codeboxr\PathaoCourier\Facade\PathaoCourier;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function ordersReport(Request $request)
    {
        $sql = OrderDetails::with('product', 'order')->where('is_deleted', '!=', true)->orderBy('created_at', 'desc');

        if (isset($request->from)) {
            $sql->whereDate('created_at', '>=', $request->from);
        }
        if (isset($request->to)) {
            $sql->whereDate('created_at', '<=', $request->to);
        }

        $ordersReports = $sql->paginate(10);
        return view('admin.customer.report', compact('ordersReports'));
    }

    public function ordersCancel(Request $request){
         if(session('name') == 'admin'){
            $sql = Order::with('product', 'orderDetails')->where('order_status', 'cancel')->where('is_deleted', '!=', true)->orderBy('created_at', 'desc');
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                });
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }

        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'cancel')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                });
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $cancel_orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-cancel', compact('cancel_orders', 'users'));
    }

    public function ordersHold(Request $request){
        $sql = Order::with('product', 'orderDetails')->where('order_status', 'hold')->where('is_deleted', '!=', true)->orderBy('created_at', 'desc');

        if (isset($request->search)) {
            $searchTerm = $request->search;
            $sql->where(function ($query) use ($searchTerm) {
            $query->orWhere('phone', $searchTerm)
            ->orWhere('orderId', $searchTerm);
            })->get();
            //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
        }

        $hold_orders = $sql->paginate(50);
        return view('admin.customer.order-hold', compact('hold_orders'));
    }

    public function ordersPending(Request $request){
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'pending')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'pending')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-pending', compact('orders', 'users'));
    }

    public function ordersComplete(Request $request){
        $sql = Order::with('product', 'orderDetails')->where('status', 3)->orderBy('created_at', 'desc');

        if (isset($request->search)) {
            $sql->where('orderId', $request->search)->where('status', 3);
        }
        $complete_orders = $sql->paginate(50);
        return view('admin.customer.order-complete', compact('complete_orders'));
    }

    public function ordersDelivery(Request $request){
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'delivered')
            ->where(function ($query) {
                $query->whereNull('pathao_order_status')
                ->orWhere('pathao_order_status', 'Delivered');
                })->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'delivered')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $delivered_orders = $sql->paginate(50);
        // dd($delivered_orders);
        return view('admin.customer.delivery-order-list', compact('delivered_orders'));
    }

    public function pendingPaymentOrder (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'pending payment')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'pending payment')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $pending_payment_orders = $sql->paginate(50);
        return view('admin.customer.pending-payment-order-list', compact('pending_payment_orders'));
    }

    //==================== Order status =========================//
    public function showCancelReasonForm ($orderId)
    {
        $order_status = 'cancel';
        return view('admin.customer.hold-cancel-form', compact('orderId', 'order_status'));
    }

    public function cancel(Request $request)
    {
        $this->validate($request, [
            'orderId' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        try {
            $cancelOrderStatus = Order::find($request->orderId);
            if (!$cancelOrderStatus) {
                return redirect()->back()->with('error', 'Order not found.');
            }
            $cancelOrderStatus->order_status = 'cancel';
            $cancelOrderStatus->notes = $request->notes;
            $cancelOrderStatus->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$cancelOrderStatus->orderId.' '. 'is made status cancel by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $cancelOrderStatus->notification()->save($notification);
        //Notification...
        return redirect('/order/cancel')->with('success', 'Order has been canceled');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    public function showHoldReasonForm ($orderId)
    {
        $order_status = 'hold';
        return view('admin.customer.hold-cancel-form', compact('orderId', 'order_status'));
    }

    public function hold(Request $request)
    {
        $this->validate($request, [
            'orderId' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        try {
            $cancelOrderStatus = Order::find($request->orderId);
            if (!$cancelOrderStatus) {
                return redirect()->back()->with('error', 'Order not found.');
            }
            $cancelOrderStatus->order_status = 'hold';
            $cancelOrderStatus->notes = $request->notes;
            $cancelOrderStatus->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$cancelOrderStatus->orderId.' '. 'is made status hold by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $cancelOrderStatus->notification()->save($notification);
        //Notification...
        return redirect('/order/hold')->with('success', 'Order has been holded');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to hold order: ' . $e->getMessage());
        }
    }

    public function pendingStatus($id)
    {
        $pendingOrderStatus = Order::find($id);
        $pendingOrderStatus->order_status = 'pending';
        $pendingOrderStatus->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$pendingOrderStatus->orderId.' '. 'is made status pending by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $pendingOrderStatus->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order has been pending');
    }


    public function statusUpdate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|array|min:1',
            'id.*' => 'required|integer',
            'action' => 'required|string|in:pending,hold,cancel,delete',
        ]);

        $id = $request->id;
        if($request->id == null){
            return redirect()->back()->withError('Please select minimum one.');
        }
        try {
        if ($request->action == 'pending'){
           $completeOrderStatusUpdate = Order::whereIn('id', $id)->get();
            foreach ($completeOrderStatusUpdate as $item) {
                $item->order_status = 'pending';
                $item->save();
                //Notification...
                $notification = new Notification();
                $notification->message = 'Order with invoice id'.' '.$item->orderId.' '. 'is made status pending by'.' '.Session::get('name');
                $notification->specific_user_id = Session::get('id');
                $notification->notification_for = "user";
                $item->notification()->save($notification);
                //Notification...
           }
            return redirect()->back()->with('success', 'Order has been pending');
        }elseif ($request->action == 'hold'){
            $holdOrderStatusUpdate = Order::whereIn('id', $id)->get();
            foreach ($holdOrderStatusUpdate as $item) {
                $item->order_status = 'hold';
                $item->save();
                //Notification...
                $notification = new Notification();
                $notification->message = 'Order with invoice id'.' '.$item->orderId.' '. 'is made status hold by'.' '.Session::get('name');
                $notification->specific_user_id = Session::get('id');
                $notification->notification_for = "user";
                $item->notification()->save($notification);
                //Notification...
            }
            return redirect()->back()->with('success', 'Order has been hold');
        }elseif ($request->action == 'cancel'){
            $cancelOrderStatusUpdate = Order::whereIn('id', $id)->get();
            foreach ($cancelOrderStatusUpdate as $item) {
                $item->order_status = 'cancel';
                $item->save();
                //Notification...
                $notification = new Notification();
                $notification->message = 'Order with invoice id'.' '.$item->orderId.' '. 'is made status cancel by'.' '.Session::get('name');
                $notification->specific_user_id = Session::get('id');
                $notification->notification_for = "user";
                $item->notification()->save($notification);
                //Notification...
            }
            return redirect()->back()->with('success', 'Order has been cancel');
        } else {
            $deleteOrderStatusUpdate = Order::whereIn('id', $id)->get();
            foreach ($deleteOrderStatusUpdate as $item) {
                // $item->delete();
                $item->is_deleted = true;
                $item->save();
                //Notification...
                $notification = new Notification();
                $notification->message = 'Order with invoice id'.' '.$item->orderId.' '. 'is deleted by'.' '.Session::get('name');
                $notification->specific_user_id = Session::get('id');
                $notification->notification_for = "user";
                $item->notification()->save($notification);
                //Notification...
            }
            return redirect()->back()->with('success', 'Order has been deleted');
        }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    public function orderReturn($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'return';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status return by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }
    public function orderDamage($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'damage';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status damage by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function orderMissing($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'missing';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status missing by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }
    public function orderDelivered($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'delivered';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status delivered by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function orderCustomerConfirm ($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'customer confirm';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status Customer Confirm by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function orderRequestReturn ($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'request return';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status request to return by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function orderPaid ($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'paid';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status paid by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function pendingPayment ($id)
    {
        $orderReturn = Order::find($id);
        $orderReturn->order_status = 'pending payment';
        $orderReturn->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$orderReturn->orderId.' '. 'is made status pending payment by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $orderReturn->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function invoiceChecked ($id)
    {
        $invoiceChecked = Order::find($id);
        $invoiceChecked->order_status = 'invoice checked';
        $invoiceChecked->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$invoiceChecked->orderId.' '. 'is made status invoice Checked by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $invoiceChecked->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function invoiced ($id)
    {
        $invoiced = Order::find($id);
        $invoiced->order_status = 'invoiced';
        $invoiced->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$invoiced->orderId.' '. 'is made status invoiced by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $invoiced->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function stockOut ($id)
    {
        $stockOut = Order::find($id);
        $stockOut->order_status = 'stock out';
        $stockOut->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$stockOut->orderId.' '. 'is made status stock out by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $stockOut->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function scheduleDelivery ($id)
    {
        $scheduleDelivery = Order::find($id);
        $scheduleDelivery->order_status = 'schedule delivery';
        $scheduleDelivery->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$scheduleDelivery->orderId.' '. 'is made status schedule delivery by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $scheduleDelivery->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order status has been updated');
    }

    public function completeStatus($id)
    {
        $cancelOrderStatus = Order::find($id);
        $cancelOrderStatus->order_status = 'complete';
        $cancelOrderStatus->save();
        //Notification...
        $notification = new Notification();
        $notification->message = 'Order with invoice id'.' '.$cancelOrderStatus->orderId.' '. 'is made status complete by'.' '.Session::get('name');
        $notification->specific_user_id = Session::get('id');
        $notification->notification_for = "user";
        $cancelOrderStatus->notification()->save($notification);
        //Notification...
        return redirect()->back()->with('success', 'Order has been complete');
    }

    public function invoiceList (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'complete')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
            //Searching...
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'complete')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(100);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.invoice_orders', compact('orders', 'users'));
    }

    public function allOrders(Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc')->where('is_deleted', '!=', true);

            //Searching...
            if (isset($request->search)) {
                $sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->orderBy('created_at', 'desc')->where('is_deleted', '!=', true);

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $all_orders = $sql->paginate(100);
        //dd($all_orders);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();

        $type = 'allOrders';
        return view('admin.customer.order-list', compact('all_orders', 'users', 'type'));
    }

    public function transferredOrders(Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->where('order_status', 'transferred')->orderBy('id', 'desc')->where('is_deleted', '!=', true);

            //Searching...
            if (isset($request->search)) {
                $sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('is_transferred', true)
            ->orderBy('created_at', 'desc')->where('is_deleted', '!=', true);

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $all_orders = $sql->paginate(100);
        //dd($all_orders);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();

        $type = 'transferredOrders';
        return view('admin.customer.order-list', compact('all_orders', 'users', 'type'));
    }

        public function deletedOrder (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->where('is_deleted', true)->orderBy('id', 'desc');

            //Searching...
            if (isset($request->search)) {
                $sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('is_deleted', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $orders = $sql->paginate(100);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.deleted-orders', compact('orders', 'users'));
    }


    public function userOrderUpdate(Request $request, $id)
    {
        $product = Product::find($request->related_product_id);

        if($product){
            $orderProduct = Order::find($id);
            $orderProduct->name = $request->name;
            $orderProduct->phone = $request->phone;
            $orderProduct->email = $request->email;
            $orderProduct->area = $request->area;
            $orderProduct->qty = $orderProduct->qty + 1;
            if($product->discount_price == null){
                $orderProduct->price = $orderProduct->price + $product->regular_price;
            }
            if($product->discount_price != null){
                $orderProduct->price = $orderProduct->price + $product->discount_price;
            }
            $orderProduct->address = $request->address;
            $orderProduct->save();

            $productOrder = new OrderDetails();
            $productOrder->order_id = $orderProduct->id;
            $productOrder->product_id = $request->related_product_id;
            $productOrder->qty = 1;
            $productOrder->size = $request->size;
            $productOrder->color = $request->color;
            if($product->discount_price == null){
                $productOrder->price = $product->regular_price;
            }
            if($product->discount_price != null){
                $productOrder->price = $product->discount_price;
            }
            $productOrder->save();
        } else {
            $order = Order::find($id);
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->area = $request->area;
            $order->price = $request->total_price;
            if($request->filled('discount')){
                $order->discount = $request->discount;
            }
            if($request->filled('advance')){
                $order->advance = $request->advance;
            }
            $order->address = $request->address;
            $order->save();
        }

        //Create Pathao New Parcel...
        if($request->courier == 'Pathao'){
            $orderDetails = Order::find($id);
            $response = PathaoCourier::order()
                        ->create([
                            "store_id"            => "185565", // Find in store list,
                            "merchant_order_id"   => $orderDetails->orderId, // Unique order id
                            "recipient_name"      => $orderDetails->name, // Customer name
                            "recipient_phone"     => $orderDetails->phone, // Customer phone
                            "recipient_address"   => $orderDetails->address, // Customer address
                            "recipient_city"      => $request->city, // Find in city method
                            "recipient_zone"      => $request->zone, // Find in zone method
                            //"recipient_area"      => "5166", // Find in Area method
                            "delivery_type"       => "48", // 48 for normal delivery or 12 for on demand delivery
                            "item_type"           => "2", // 1 for document,2 for parcel
                            "special_instruction" => $request->pathao_special_note,
                            "item_quantity"       => "1", // item quantity
                            "item_weight"         => "0.5", // parcel weight
                            "amount_to_collect"   => (int) $orderDetails->price, // amount to collect
                            "item_description"    => "Not any" // product details
                        ]);
            $responseArray = json_decode(json_encode($response), true);
            $consignmentId = $responseArray['consignment_id'];
            $orderDetails->consignmentId = $consignmentId;
            $orderDetails->save();
        }

        if($request->courier == 'Steadfast'){
            $orderDetails = Order::find($id);
            // API endpoint
            $apiEndpoint = 'https://portal.packzy.com/api/v1/create_order';

            // API-Key and Secret-Key from database
            $generalSetting = GeneralSetting::first();
            $apiKey = $generalSetting->steadfast_api_key;
            $secretKey = $generalSetting->steadfast_secret_key;

            // The request parameters
            $invoice           = $orderDetails->orderId;
            $cod_amount        = (int) $orderDetails->price;
            $recipient_name    = $orderDetails->name;
            $recipient_phone   = $orderDetails->phone;
            $recipient_address = $orderDetails->address;
            $note              = $orderDetails->note;


            // The headers
            $headers = [
                'Api-Key' => $apiKey,
                'Secret-Key' => $secretKey,
                'Content-Type' => 'application/json',
            ];

            // The request payload
            $payload = [
                'invoice'           => $invoice,
                'cod_amount'        => $cod_amount,
                'recipient_name'    => $recipient_name,
                'recipient_phone'   => $recipient_phone,
                'recipient_address' => $recipient_address,
                'note'              => $note,
                // Add any other parameters as needed
            ];

            try {
                // Make the API call using GuzzleHttp
                $response = Http::withHeaders($headers)->post($apiEndpoint, $payload);

                // Process the API response as needed
                $responseData = $response->json();

                // Check if the response has the "consignment" key
                if (isset($responseData['consignment'])) {
                    $consignmentData = $responseData['consignment'];
                    $consignmentId   = $consignmentData['consignment_id'];

                    $orderDetails->consignmentId = $consignmentId;
                    $orderDetails->save();

                    // Do something with $consignmentId or other data

                    // return response()->json($responseData);
                }
            }
            catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        //Update Order with pathao details...
        $orderDetails = Order::find($id);
        $orderDetails->courier_name = $request->courier;
        $orderDetails->pathao_city_id = $request->city;
        $orderDetails->pathao_zone_id = $request->zone;
        $orderDetails->pathao_city_name = $request->city_name;
        $orderDetails->pathao_zone_name = $request->zone_name;
        $orderDetails->pathao_special_note = $request->pathao_special_note;
        $orderDetails->otherCourierDetails = $request->otherCourierDetails;
        $orderDetails->delivery_charge_type = $request->delivery_charge_type;
        $orderDetails->order_status = 'complete';
        $orderDetails->save();

        $this->setSuccessMessage('Order has been updated');
        return redirect()->back();
    }

    public function userDropshippingOrderTransfer(Request $request, $id)
    {
        $action = $request->action;
        if($action == 'update'){
            $product = Product::find($request->related_product_id);
            if($product){
                $orderProduct = Order::find($id);
                $orderProduct->name = $request->name;
                $orderProduct->phone = $request->phone;
                $orderProduct->email = $request->email;
                $orderProduct->area = $request->area;
                $orderProduct->qty = $orderProduct->qty + 1;
                if($product->discount_price == null){
                    $orderProduct->price = $orderProduct->price + $product->regular_price;
                }
                if($product->discount_price != null){
                    $orderProduct->price = $orderProduct->price + $product->discount_price;
                }
                $orderProduct->address = $request->address;
                $orderProduct->save();

                $productOrder = new OrderDetails();
                $productOrder->order_id = $orderProduct->id;
                $productOrder->product_id = $request->related_product_id;
                $productOrder->qty = 1;
                $productOrder->size = $request->size;
                $productOrder->color = $request->color;
                if($product->discount_price == null){
                    $productOrder->price = $product->regular_price;
                }
                if($product->discount_price != null){
                    $productOrder->price = $product->discount_price;
                }
                $productOrder->save();
            } else {
                $order = Order::find($id);
                $order->name = $request->name;
                $order->phone = $request->phone;
                $order->email = $request->email;
                $order->area = $request->area;
                $order->price = $request->total_price;
                if($request->filled('discount')){
                    $order->discount = $request->discount;
                }
                if($request->filled('advance')){
                    $order->advance = $request->advance;
                }
                $order->address = $request->address;
                $order->save();
            }

            //Update Order with other details...
            $orderDetails = Order::find($id);
            $orderDetails->pathao_special_note = $request->pathao_special_note;
            $orderDetails->delivery_charge_type = $request->delivery_charge_type;
            $orderDetails->payment_gateway = $request->payment_gateway;
            $orderDetails->transaction_id = $request->transaction_id;
            $orderDetails->save();

            $this->setSuccessMessage('Order has been updated');
            return redirect()->back();
        }

        if ($action == 'transfer') {
            $orderDetails = Order::with('orderDetails.product')->find($id);

            if (!$orderDetails) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            $generalSetting = GeneralSetting::first();
            $appKey = $generalSetting->droploo_app_key;
            $appSecret = $generalSetting->droploo_app_secret;
            $userName = $generalSetting->droploo_username;
            $apiEndpoint = 'https://backend.droploo.com/api/product/create-order';

            $payload = [
                'invoice_number'        => $orderDetails->orderId,
                'customer_name'         => $orderDetails->name,
                'customer_phone'        => $orderDetails->phone,
                'delivery_cost'         => (int)$orderDetails->area,
                'customer_address'      => $orderDetails->address,
                'price'                 => (int)$orderDetails->price,
                'discount'              => (int)$orderDetails->discount,
                'advance'               => (int)$orderDetails->advance,
                'product_quantity'      => $orderDetails->qty ?? $orderDetails->orderDetails->sum('qty'),
                'delivery_charge_type'  => $orderDetails->delivery_charge_type,
                'payment_type'          => 'cod',
                'order_type'            => 'Dropshipping',
                'special_notes'         => $orderDetails->pathao_special_note,
                'payment_gateway'       => $orderDetails->payment_gateway,
                'transaction_id'        => $orderDetails->transaction_id,
                'products'              => $orderDetails->orderDetails->map(function ($detail) {
                    return [
                        'id'    => optional($detail->product)->b_product_id,
                        'price' => $detail->price,
                        'color' => $detail->color,
                        'size'  => $detail->size,
                        'qty'   => $detail->qty,
                    ];
                })->filter(fn($p) => $p['id'])->values()->all(),
            ];

            try {
                $response = Http::withHeaders([
                    'App-Secret' => $appSecret,
                    'App-Key'    => $appKey,
                    'Username'   => $userName,
                ])->post($apiEndpoint, $payload);

                if ($response->successful()) {
                    $orderDetails->order_status   = 'transferred';
                    $orderDetails->is_transferred = true;
                    $orderDetails->save();

                    return redirect()->back()->with('success', 'Order has been transferred successfully!');
                } else {
                    $errorResponse = $response->json();
                    return redirect()->back()->with('error', $errorResponse['message'] ?? 'Unknown error from API.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Exception occurred: ' . $e->getMessage());
            }
        }
    }

    public function orderDetailsDelete($id)
    {
        $orderDeleteFromAdminPanel = OrderDetails::find($id);
        $order = Order::where('id', $orderDeleteFromAdminPanel->order_id)->first();
        $orderDeleteFromAdminPanel->delete();

        $this->setSuccessMessage('Order has been deleted');
        return redirect()->back();
    }

    public function todayManual (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('created_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_type', 'Manual')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('created_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('order_type', 'Manual')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-manual-list', compact('orders', 'users'));
    }

    public function todayOrders (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('created_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('created_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-today-list', compact('orders', 'users'));
    }

    public function allManual (Request $request)
    {
        $currentMonth = Carbon::now()->format('m');
        if(session('name') == 'admin'){
            $sql = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $currentMonth)
            ->with('orderDetails', 'admin')->orderBy('id', 'desc')
            ->where('is_deleted', '!=', true)
            ->where('order_type', 'Manual');
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $currentMonth)
            ->where('employee_id', $employee_id)
            ->where('order_type', 'Manual')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-manual-list', compact('orders', 'users'));
    }

    public function allWebsite (Request $request)
    {
        $currentMonth = Carbon::now()->format('m');
        if(session('name') == 'admin'){
            $sql = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $currentMonth)
            ->with('orderDetails', 'admin')->orderBy('id', 'desc')
            ->where('is_deleted', '!=', true)
            ->where('order_type', 'Website');
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $currentMonth)
            ->where('employee_id', $employee_id)
            ->where('order_type', 'Website')
            ->where('is_deleted', '!=', true)
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-website-list', compact('orders', 'users'));
    }

    public function todayCancel (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'cancel')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('updated_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('order_status', 'cancel')
            ->where('is_deleted', '!=', true)
            ->orderBy('updated_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-cancel-today-list', compact('orders', 'users'));
    }

    public function todayHold (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'hold')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('updated_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('order_status', 'hold')
            ->where('is_deleted', '!=', true)
            ->orderBy('updated_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-hold-today-list', compact('orders', 'users'));
    }

    public function todayPending (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'pending')->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('updated_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('order_status', 'pending')
            ->where('is_deleted', '!=', true)
            ->orderBy('updated_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
        }

        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-pending', compact('orders', 'users'));
    }

    public function todayDelivered (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->with('orderDetails', 'admin')->orderBy('id', 'desc')->where('order_status', 'delivered')
            ->where('pathao_order_status', null)->where('is_deleted', '!=', true);
            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
                //$sql->orWhere('orderId', $request->search)->orWhere('phone', $request->search);
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }
        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->whereDate('updated_at', \Illuminate\Support\Carbon::today())
            ->where('employee_id', $employee_id)
            ->where('order_status', 'delivered')
            ->where('is_deleted', '!=', true)
            ->where('pathao_order_status', null)
            ->orderBy('updated_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('updated_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('updated_at', '<=', $request->to);
            }
            //Searching...
        }

        $delivered_orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.delivery-order-list', compact('delivered_orders', 'users'));
    }

    public function orderReturnList(Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->where('order_status', 'return')->orderBy('id', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'return')
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-return', compact('orders', 'users'));
    }

    public function orderDamageList(Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->where('order_status', 'damage')->orderBy('id', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'damage')
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-damage', compact('orders', 'users'));
    }

    public function orderMissingList(Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->where('order_status', 'missing')->orderBy('id', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
            if(isset($request->user_id)){
                $sql->where('employee_id', (int)$request->user_id);
            }

        }
        else{
            $employee_id = Session::get('id');
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $employee_id)
            ->where('order_status', 'missing')
            ->orderBy('created_at', 'desc');

            //Searching...
            if (isset($request->search)) {
                $searchTerm = $request->search;
                $sql->where(function ($query) use ($searchTerm) {
                $query->where('phone', $searchTerm)
                ->orWhere('orderId', $searchTerm);
                })->get();
            }
            if (isset($request->from)) {
                $sql->whereDate('created_at', '>=', $request->from);
            }
            if (isset($request->to)) {
                $sql->whereDate('created_at', '<=', $request->to);
            }
            //Searching...
        }
        $orders = $sql->paginate(50);
        $users = Admin::orderBy('id', 'desc')->where('id', '!=', session()->get('id'))->get();
        return view('admin.customer.order-missing', compact('orders', 'users'));
    }

    //Pathao Webhook Implementation for Order Status....
    public function webHookForOrderStatus (Request $request)
    {
        // Parse the JSON payload from the webhook request
        $payload = json_decode($request->getContent(), true);

        // Extract relevant data from the payload
        $consignmentId = $payload['consignment_id'];
        $orderStatus = $payload['order_status'];
        $merchantOrderId = $payload['merchant_order_id'];

        // Find the order in your database by matching merchant_order_id
        $order = Order::where('orderId', $merchantOrderId)->first();

        if ($order) {
            // Update the order status based on the payload order_status
            $order->pathao_order_status = $orderStatus;
            if($orderStatus == 'Return'){
                $order->order_status = 'return';
            }
            elseif($orderStatus == 'Delivered'){
                $order->order_status = 'delivered';
            }
            $order->save();

            // Optionally, you can perform additional actions or logging here
        }

        // Respond with a success message to the webhook provider
        return response('Webhook received and processed.', 200);
    }
    //Pathao Webhook Implementation for Order Status....
}
