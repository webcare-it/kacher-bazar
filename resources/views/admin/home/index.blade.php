@extends('admin.master')

@include('admin.includes.action-css')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            @if (session('name') == 'admin')
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
            <a href="{{url('/today-orders')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Orders</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('created_at', \Illuminate\Support\Carbon::today())->where('is_deleted', '!=', true)->get()->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/today-manual')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Manual</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('created_at', \Illuminate\Support\Carbon::today())->where('order_type', 'Manual')->where('is_deleted', '!=', true)->get()->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/today-pending')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Pending</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->where('order_status', 'pending')->where('is_deleted', '!=', true)->get()->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/order/pending-payment')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Pending Payment</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::where('order_status', 'pending payment')->get()->where('is_deleted', '!=', true)->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/today-delivered')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Delivered</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->where('order_status', 'delivered')->where('pathao_order_status', null)->where('is_deleted', '!=', true)->get()->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/today-cancel')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Cancel</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->where('order_status', 'cancel')->where('is_deleted', '!=', true)->get()->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            <a href="{{url('/today-hold')}}">
                <div class="col">
                    <div class="card radius-10 overflow-hidden bg-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Today Hold</p>
                                    <h5 class="mb-0 text-white">
                                        {{ \App\Models\order::whereDate('updated_at', \Illuminate\Support\Carbon::today())->where('order_status', 'hold')->get()->where('is_deleted', '!=', true)->count() }}
                                    </h5>
                                </div>
                                <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                </div>
                            </div>
                        </div>
                        <div class="" id="chart3"></div>
                    </div>
                </div>
            </a>
            </div>
            <div class="col">
                <form method="GET" action="{{ url('/admin/dashboard') }}" class="form-inline mb-3">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-gradient-blues">From</span>
                        <input type="date" class="form-control" name="order_from" placeholder=""
                            aria-label="Username">
                        <span class="input-group-text bg-gradient-burning">To</span>
                        <input type="date" class="form-control" name="order_to" placeholder=""
                            aria-label="Server">
                        <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Search</button>
                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-sm btn-danger"><i
                                class="fa fa-search"></i> Clear</a>
                    </div>
                </form>
            </div>
            @if ($filterDate != '0')
            <div class="col">
                <h5>{{$filterDate}}</h5>
            </div>
            @endif
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                <a href="{{url('/all-orders')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-danger">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Total Orders</p>
                                     <h5 class="mb-0 text-white">{{ $totalOrders }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-cart font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart1"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/all-website-orders')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-warning">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Website Orders</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $websiteOrder }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/all-manual-orders')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-info">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Manual Orders</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $manualOrder }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/pending')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-success">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Pending</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $pendingOrder }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/pending-payment')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-danger">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Pending Payment</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $pendingPayment }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/hold')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-info">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">On Hold</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $onHold }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="#">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-success">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Schedule Delivery</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $scheduleDelivery }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/cancel')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-danger">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Cancelled</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $cancelledOrder }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/invoice')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-success">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Pending Invoice</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $completedOrder }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/delivery')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-info">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Delivered</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $delivered }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="#">
                    <div class="col">
                        <div class="card radius-10 overflow-hidden bg-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-white">Completed</p>
                                        <h5 class="mb-0 text-white">
                                            {{ $pathaoCompletedOrder }}
                                        </h5>
                                    </div>
                                    <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="chart3"></div>
                        </div>
                    </div>
                   </a>
                <a href="#">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-warning">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Stock Out</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $stockOut }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="#">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-danger">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Customer Confirmed</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $customerConfirm }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="#">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-info">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Request to Return</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $requestReturn }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="#">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-success">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Paid</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $paid }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                 <a href="{{url('/order/return/list')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-danger">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Return</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $return }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
                <a href="{{url('/order/damage/list')}}">
                 <div class="col">
                     <div class="card radius-10 overflow-hidden bg-info">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div>
                                     <p class="mb-0 text-white">Damage</p>
                                     <h5 class="mb-0 text-white">
                                         {{ $damage }}
                                     </h5>
                                 </div>
                                 <div class="ms-auto text-white"> <i class='bx bx-group font-30'></i>
                                 </div>
                             </div>
                         </div>
                         <div class="" id="chart3"></div>
                     </div>
                 </div>
                </a>
             </div>
             <div class="row mt-5">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <h5 class="mb-1">Customer orders</h5>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{ url('/admin/dashboard') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search orderId and Customer phone...">
                                            <button type="submit"
                                                class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/admin/dashboard') }}"
                                                class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if (session('name') == 'admin')
                                <div class="row">
                                    <div class="col-md-4">
                                        <form action="{{ url('/admin/dashboard') }}" method="get"
                                            class="user-form form-group mb-3">
                                            @csrf
                                            <div class="input-group">
                                                <select name="user_id" class="form-control">
                                                    <option selected disabled>-- Select User --</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-danger">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-8">
                                        <form method="GET" action="{{ url('/admin/dashboard') }}"
                                            class="form-inline mb-3">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-gradient-blues">From</span>
                                                <input type="date" class="form-control" name="from"
                                                    placeholder="From date" aria-label="Username">
                                                <span class="input-group-text bg-gradient-burning">To</span>
                                                <input type="date" class="form-control" name="to"
                                                    placeholder="To date" aria-label="Server">
                                                <button type="submit" class="btn btn-sm btn-info"><i
                                                        class="fa fa-search"></i> Search</button>
                                                <a href="{{ url('/admin/dashboard') }}" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-search"></i> Clear</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ url('/order/update') }}" method="post">
                                @csrf
                                @include('admin.includes.action-button')
                                <div class="mt-3">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">Select</th>
                                                <th width="5%">SL</th>
                                                <th width="15%">Order ID</th>
                                                <th width="15%">Customer</th>
                                                <th width="15%">Product</th>
                                                <th width="20%">Total</th>
                                                <th width="5%">Status</th>
                                                <th width="10%">Date</th>
                                                <th width="20%">Users</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td>
                                                        @if ($order->order_status != null)
                                                            <input type="checkbox" name="id[]"
                                                                id="id{{ $order->id }}"
                                                                value="{{ $order->id }}" />
                                                        @endif
                                                    </td>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <span class="badge bg-info"
                                                            style="font-size: 12px; color: black">{{env('APP_NAME')}}</span><br />
                                                        <span
                                                            style="font-size: 16px; font-weight:600;">{{ $order->orderId ?? 'No order id found' }}</span><br />
                                                        <span
                                                            class="badge rounded-pill bg-primary">{{ $order->order_type }}</span>
                                                        <br />
                                                        {{ $order->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        {{ $order->name ?? 'No name found' }}<br />
                                                        <span
                                                            style="color: green">{{ $order->phone ?? 'No phone found' }}</span><br />
                                                        {{ substr($order->address, 0, 70) ?? 'No address found' }} <br />
                                                        <span
                                                            class="badge rounded-pill {{ $order->customer_type == 'Old Customer' ? 'bg-danger' : 'bg-success' }}">{{ $order->customer_type }}</span>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        @foreach ($order->orderDetails as $details)
                                                            {{ $order->qty ?? 'No name found' }}X
                                                            {{ $details->product?->name }}<br />
                                                            {{ 'Size: ' . $details->size ?? '' }} |
                                                            {{ 'Color: ' . $details->color ?? '' }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <b>Amount :</b> {{ $order->price }} Tk. <br />
                                                        <b>Delivery :</b> {{ $order->area }} Tk.
                                                    </td>
                                                    <td>
                                                        <div class="action-dropdown-menu">
                                                            <a href="javascript:;" class="action-dropdown-link">
                                                                {{ ucfirst($order->order_status) }}
                                                            </a>
                                                            <ul class="action-btn-list">
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/hold/form/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        On Hold
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/pending-payment/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Pending Payment
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/order/schedule-delivery/status/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Schedule Delivery
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/cancel/form/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Cancel
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/complete/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Complete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                    <td>{{ Str::ucfirst($order->admin?->name) }}</td>
                                                    <td>
                                                        <a href="{{ url('/order/view/' . $order->id) }}"
                                                            class="btn btn-sm btn-info">Edit</a>
                                                        {{-- <a href="{{ url('/order/pdf/' . $order->id) }}" class="btn btn-sm btn-primary">Invoice</a> --}}
                                                        <!-- <a href="{{ url('/order/return/status/' . $order->id) }}" class="btn btn-sm btn-info">Return</a>
                                                            <a href="{{ url('/order/damage/status/' . $order->id) }}" class="btn btn-sm btn-danger">Damage</a>
                                                            <a href="{{ url('/order/missing/status/' . $order->id) }}" class="btn btn-sm btn-warning">Missing</a>
                                                            <a href="{{ url('/order/delivered/status/' . $order->id) }}" class="btn btn-sm btn-warning">Delivered</a> -->

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                <div class="row mt-5">
                    <div class="col">
                        <div class="card radius-10 mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <h5 class="mb-1">Product Reports</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    {{-- <div class="col-md-4">
                                        <form action="{{ url('/admin/dashboard') }}" method="GET">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search orderId and Customer phone...">
                                                <button type="submit"
                                                    class="input-group-text bg-primary text-white">Search</button>
                                                <a href="{{ url('/admin/dashboard') }}"
                                                    class="input-group-text bg-danger text-white">Clear</a>
                                            </div>
                                        </form>
                                    </div> --}}
                                </div>

                                @if (session('name') == 'admin')
                                    <div class="row">
                                        {{-- <div class="col-md-4">
                                            <form action="{{ url('/admin/dashboard') }}" method="get"
                                                class="user-form form-group mb-3">
                                                @csrf
                                                <div class="input-group">
                                                    <select name="user_id" class="form-control">
                                                        <option selected disabled>-- Select User --</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-danger">Filter</button>
                                                </div>
                                            </form>
                                        </div> --}}
                                        <div class="col-md-12">
                                            <form method="GET" action="{{ url('/admin/dashboard') }}"
                                                class="form-inline mb-3">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-gradient-blues">From</span>
                                                    <input type="date" class="form-control" name="product_from"
                                                        placeholder="From date" aria-label="Username">
                                                    <span class="input-group-text bg-gradient-burning">To</span>
                                                    <input type="date" class="form-control" name="product_to"
                                                        placeholder="To date" aria-label="Server">
                                                    <button type="submit" class="btn btn-sm btn-info"><i
                                                            class="fa fa-search"></i> Search</button>
                                                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-search"></i> Clear</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ url('/order/update') }}" method="post">
                                    @csrf
                                    {{-- @include('admin.includes.action-button') --}}
                                    <div class="mt-3">
                                        <table class="table table-striped table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="5%">SL</th>
                                                    <th width="15%">Product Name</th>
                                                    <th width="15%">Quantity</th>
                                                    <th width="15%">Purchase Price</th>
                                                    <th width="20%">Sale Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $key => $product)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>
                                                            @php
                                                                $quantity = 0;
                                                            @endphp
                                                            @foreach ($product->orderDetails as $details)
                                                                @php
                                                                    $quantity = $quantity+$details->qty;
                                                                @endphp
                                                            @endforeach
                                                            {{$quantity}}
                                                        </td>
                                                        <td>{{$product->buy_price}}</td>
                                                        <td>{{$product->regular_price}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col">
                        <div class="card radius-10 mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div>
                                            <h5 class="mb-1">Recent Updates</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    {{-- <div class="col-md-4">
                                        <form action="{{ url('/admin/dashboard') }}" method="GET">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Search orderId and Customer phone...">
                                                <button type="submit"
                                                    class="input-group-text bg-primary text-white">Search</button>
                                                <a href="{{ url('/admin/dashboard') }}"
                                                    class="input-group-text bg-danger text-white">Clear</a>
                                            </div>
                                        </form>
                                    </div> --}}
                                </div>

                                @if (session('name') == 'admin')
                                    <div class="row">
                                    </div>
                                @endif

                                <form action="{{ url('/order/update') }}" method="post">
                                    @csrf
                                    {{-- @include('admin.includes.action-button') --}}
                                    <div class="mt-3">
                                        <table class="table table-striped table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="1%">SL</th>
                                                    <th width="15%">Notification Message</th>
                                                    <th width="15%">Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notifications as $key => $notification)
                                                    <tr>
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        <td>{{ $notification->message }}</td>
                                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{$notifications->links()}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <h2>Welcome {{ session('name') }}</h2>
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->get()->count() }}</h3>
                                <h6>Total Order</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ $monthlyPerformance }}%</h3>
                                <h6>Monthly Performance</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ $specificEmployeeRank ?? 'No rank yet' }}</h3>
                                <h6>Rank</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    {{-- <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->get()->count() }}</h3>
                                <h6>Total Order</h6>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->whereDate('created_at', \Illuminate\Support\Carbon::today())->count() }}
                                </h3>
                                <h6>Today Order</h6>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'pending')->get()->count() }}</h3>
                            <h6>On Hold</h6>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>42</h3>
                            <h6>Processing</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>421</h3>
                            <h6>Pending Payment</h6>
                        </div>
                    </div>
                </div> --}}
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'pending')->get()->count() }}
                                </h3>
                                <h6>Total Pending</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'pending')->whereDate('created_at', \Illuminate\Support\Carbon::today())->get()->count() }}
                                </h3>
                                <h6>Today Pending</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'hold')->get()->count() }}
                                </h3>
                                <h6>Total Hold</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'hold')->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}
                                </h3>
                                <h6>Today Hold</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'cancel')->get()->count() }}
                                </h3>
                                <h6>Total Canceled</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'cancel')->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}
                                </h3>
                                <h6>Today Canceled</h6>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'completed')->get()->count() }}</h3>
                            <h6>Completed</h6>
                        </div>
                    </div>
                </div> --}}
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'delivered')->get()->count() }}
                                </h3>
                                <h6>Total Delivered</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'delivered')
                                ->where('pathao_order_status', null)->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}
                                </h3>
                                <h6>Today Delivered</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'return')->get()->count() }}
                                </h3>
                                <h6>Return</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', session('id'))->where('order_status', 'damage')->get()->count() }}
                                </h3>
                                <h6>Damage</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ url('/order/update') }}" method="post">
                                @csrf
                                @include('admin.includes.action-button')
                                <div class="mt-3">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">Select</th>
                                                <th width="5%">SL</th>
                                                <th width="15%">Order ID</th>
                                                <th width="15%">Customer</th>
                                                <th width="15%">Product</th>
                                                <th width="20%">Total</th>
                                                <th width="5%">Status</th>
                                                <th width="10%">Date</th>
                                                <th width="20%">Users</th>
                                                <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td>
                                                        @if ($order->order_status != null)
                                                            <input type="checkbox" name="id[]"
                                                                id="id{{ $order->id }}"
                                                                value="{{ $order->id }}" />
                                                        @endif
                                                    </td>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <span class="badge bg-info"
                                                            style="font-size: 12px; color: black">{{env('APP_NAME')}}</span><br />
                                                        <span
                                                            style="font-size: 16px; font-weight:600;">{{ $order->orderId ?? 'No order id found' }}</span><br />
                                                        <span
                                                            class="badge rounded-pill bg-primary">{{ $order->order_type }}</span>
                                                        <br />
                                                        {{ $order->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        {{ $order->name ?? 'No name found' }}<br />
                                                        <span
                                                            style="color: green">{{ $order->phone ?? 'No phone found' }}</span><br />
                                                        {{ substr($order->address, 0, 70) ?? 'No address found' }} <br />
                                                        <span
                                                            class="badge rounded-pill {{ $order->customer_type == 'Old Customer' ? 'bg-danger' : 'bg-success' }}">{{ $order->customer_type }}</span>
                                                        <br />
                                                    </td>
                                                    <td>
                                                        @foreach ($order->orderDetails as $details)
                                                            {{ $order->qty ?? 'No name found' }}X
                                                            {{ $details->product?->name }}<br />
                                                            {{ 'Size: ' . $details->size ?? '' }} |
                                                            {{ 'Color: ' . $details->color ?? '' }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <b>Amount :</b> {{ $order->price }} Tk. <br />
                                                        <b>Delivery :</b> {{ $order->area }} Tk.
                                                    </td>
                                                    <td>
                                                        <div class="action-dropdown-menu">
                                                            <a href="javascript:;" class="action-dropdown-link">
                                                                {{ ucfirst($order->order_status) }}
                                                            </a>
                                                            <ul class="action-btn-list">
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/hold/form/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        On Hold
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/pending-payment/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Pending Payment
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/order/schedule-delivery/status/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Schedule Delivery
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/cancel/form/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Cancel
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/complete/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Complete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                    <td>{{ Str::ucfirst($order->admin?->name) }}</td>
                                                    <td>
                                                        <a href="{{ url('/order/view/' . $order->id) }}"
                                                            class="btn btn-sm btn-info">Edit</a>
                                                        {{-- <a href="{{ url('/order/pdf/' . $order->id) }}" class="btn btn-sm btn-primary">Invoice</a> --}}
                                                        <!-- <a href="{{ url('/order/return/status/' . $order->id) }}" class="btn btn-sm btn-info">Return</a>
                                                            <a href="{{ url('/order/damage/status/' . $order->id) }}" class="btn btn-sm btn-danger">Damage</a>
                                                            <a href="{{ url('/order/missing/status/' . $order->id) }}" class="btn btn-sm btn-warning">Missing</a>
                                                            <a href="{{ url('/order/delivered/status/' . $order->id) }}" class="btn btn-sm btn-warning">Delivered</a> -->

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
            @endif
        </div>
    </div>
@endsection

@push('script')
    @include('admin.includes.action-button-js')

    <script>
        function selects() {
            var selec = document.getElementsByName('id[]');
            console.log(selec);
            for (var i = 0; i < selec.length; i++) {
                if (selec[i].type == 'checkbox')
                    selec[i].checked = true;
            }
        }

        function deSelect() {
            var selec = document.getElementsByName('id[]');
            for (var i = 0; i < selec.length; i++) {
                if (selec[i].type == 'checkbox')
                    selec[i].checked = false;

            }
        }
    </script>
@endpush
