<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index ()
    {
        $users = Admin::where('name', '!=', 'admin')->get();
        return view('admin.user.index', compact('users'));
    }

    public function addUser ()
    {
        return view('admin.user.add_user');
    }

    public function storeUser (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'password' => 'required|min:8',
        ]);

        try {
            $user = new Admin();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect('/users')->withSuccess('User has been created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function activateUser ($id)
    {
        $user = Admin::where('id', $id)->first();
        if($user->is_active == 1){
            return redirect()->back()->withError('Already Active!');
        }

        else{
            $user->is_active = 1;
            $user->save();
            return redirect()->back()->withSuccess('Activated Successfully!');
        }
    }

    public function inActivateUser ($id)
    {
        $user = Admin::where('id', $id)->first();
        if($user->is_active == 0){
            return redirect()->back()->withError('Already InActive!');
        }

        else{
            $user->is_active = 0;
            $user->save();
            return redirect()->back()->withSuccess('InActivated Successfully!');
        }
    }

    public function editUser ($id)
    {
        $user = Admin::find($id);
        return view('admin.user.edit_user', compact('user'));
    }

    public function updateUser (Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'order_limit' => 'nullable|integer|min:0',
            'password' => 'nullable|min:8',
        ]);

        try {
            $user = Admin::find($id);
            if (!$user) {
                return redirect('/users')->with('error', 'User not found.');
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->order_limit = $request->order_limit;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();
            return redirect('/users')->withSuccess('Updated Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function deleteUser ($id)
    {
        $user = Admin::find($id);

        //Get All Assigned Order...
        $orders = Order::where('employee_id', $user->id)->get();
        foreach ($orders as $order) {
            $order->employee_id = 1;
            $order->save();
        }
        //Get All Assigned Order...

        $user->delete();
        return redirect('/users')->withSuccess('Deleted Successfully!');
    }

    public function detailsUser ($id)
    {
        $user = Admin::find($id);

        //Generate Rank According to Completed Orders...
        $currentMonth = Carbon::now()->format('m');

        // $rankedEmployees = Order::select('employee_id')
        // ->selectRaw('COUNT(CASE WHEN order_status = "delivered" THEN 1 ELSE NULL END) as completed_orders_count')
        // ->groupBy('employee_id')
        // ->orderByDesc('completed_orders_count')
        // ->whereYear('created_at', Carbon::now()->year)
        // ->whereMonth('created_at', $currentMonth)
        // ->get();

        // $rankedEmployees = $rankedEmployees->map(function ($employee, $index) {
        //     $employee->rank = $index + 1;
        //     return $employee;
        // });

        // Calculate performance percentage for each employee
        $performanceData = DB::table('orders')
        ->select('employee_id', DB::raw('SUM(CASE WHEN order_status = "delivered" THEN 1 ELSE 0 END) / COUNT(*) * 100 as performance_percentage'))
        ->whereYear('updated_at', Carbon::now()->year)
        ->whereMonth('updated_at', $currentMonth)
        ->groupBy('employee_id')
        ->get();

        // Rank employees based on performance_percentage
        $rankedEmployees = $performanceData->sortByDesc('performance_percentage')
        ->values()
        ->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });

        $specificEmployeeRank = $rankedEmployees->where('employee_id', $id)->pluck('rank')->first();
        //Generate Rank According to Completed Orders...

        //Generate Monthly Performance According Order Status...
        if($specificEmployeeRank != null){
            $allOrders = Order::where('employee_id', $id)
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();

            //According to delivered orders....
            $completedOrders = Order::where('employee_id', $id)->where('order_status', 'delivered')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();
            $monthlyPerformance = number_format((($completedOrders/$allOrders)*100),3);
            //According to delivered orders....

            //According to return orders....
            $returnOrders = Order::where('employee_id', $id)->where('order_status', 'return')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();
            $returnKPI = number_format((($returnOrders/$allOrders)*100),3);
            //According to return orders....

            //According to cancel orders....
            $cancelOrders = Order::where('employee_id', $id)->where('order_status', 'cancel')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();
            $cancelKPI = number_format((($cancelOrders/$allOrders)*100),3);
            //According to cancel orders....

            //According to delivery charged orders....
            $allDeliveredOrders = Order::where('employee_id', $id)->where('order_status', 'delivered')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();

            $deliveryChargedOrders = Order::where('employee_id', $id)->where('order_status', 'delivered')
            ->where('delivery_charge_type', 'Advance')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)->count();
            if($allDeliveredOrders==0){
                    $deliveryChargeKPI = 0.000;
                }
                if($allDeliveredOrders>0){
                    $deliveryChargeKPI = number_format((($deliveryChargedOrders/$allDeliveredOrders)*100),3);
                }
            //According to delivery charged orders....
        }
        else{
            $monthlyPerformance = '0.000';
            $returnKPI = '0.000';
            $cancelKPI = '0.000';
            $deliveryChargeKPI = '0.000';
        }
        //Generate Monthly Performance According Order Status...
        return view('admin.user.user_details', compact('user', 'specificEmployeeRank', 'monthlyPerformance', 'returnKPI', 'cancelKPI', 'deliveryChargeKPI'));
    }

    public function orderListUser (Request $request, $order_type, $user_id)
    {
        if($order_type == 'all'){
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $user_id)
            ->where('is_deleted', '!=', true)
            ->orderBy('id', 'desc');

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
        elseif($order_type == 'today'){
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $user_id)
            ->where('is_deleted', '!=', true)
            ->whereDate('created_at', Carbon::today())->orderBy('id', 'desc');

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
        else{
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $user_id)
            ->where('is_deleted', '!=', true)
            ->where('order_status', $order_type)
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
        return view('admin.user.order_list', compact('orders', 'order_type', 'user_id'));
    }

    public function orderListTodayUser (Request $request, $order_type, $user_id)
    {
            $sql = Order::with('orderDetails', 'admin')
            ->where('employee_id', $user_id)
            ->where('is_deleted', '!=', true)
            ->where('order_status', $order_type)
            ->where('pathao_order_status', null)
            ->whereDate('updated_at', Carbon::today())->orderBy('id', 'desc');

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

        $orders = $sql->paginate(100);
        return view('admin.user.order_list', compact('orders', 'order_type', 'user_id'));
    }

    public function userAssignOrderList (Request $request)
    {
        if(session('name') == 'admin'){
            $sql = Order::with('orderDetails', 'admin')->orderBy('id', 'desc');

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
        return view('admin.customer.user-assign-orders', compact('orders', 'users'));
    }

    public function assignUserOrder (Request $request)
    {
        $selectedOrderIds = $request->id;
        $assign_user_id = $request->assign_user_id;
        if($selectedOrderIds==null){
            return redirect()->back()->with('error', 'Select Minimum One!');
        }
        if($assign_user_id==null){
            return redirect()->back()->with('error', 'No user is selected!');
        }

            //Update employee...
            foreach ($selectedOrderIds as $orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->employee_id = $assign_user_id;
                    $order->save();
                }
            }
            //Update employee...
            return redirect()->back()->with('success', 'User is assigned successfully!');
    }
}
