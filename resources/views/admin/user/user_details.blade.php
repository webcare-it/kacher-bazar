@extends('admin.master')

@include('admin.includes.action-css')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h2>{{$user->name}}</h2>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', $user->id)->whereMonth('created_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                                <h6>Total Order</h6>
                            </div>
                        </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{$monthlyPerformance}}%</h3>
                                <h6>Monthly Performance</h6>
                            </div>
                        </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{$returnKPI}}%</h3>
                            <h6>Return KPI</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{$cancelKPI}}%</h3>
                            <h6>Cancelled Orders KPI</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{$deliveryChargeKPI}}%</h3>
                            <h6>Advance Delivery Charge KPI</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{$specificEmployeeRank?? 'No rank yet'}}</h3>
                                <h6>Rank</h6>
                            </div>
                        </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-center">
                {{-- <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/all/'.$user->id)}}">
                        <div class="card mb-3">
                            <div class="card-body text-center">
                                <h3>{{ \App\Models\Order::where('employee_id', $user->id)->get()->count() }}</h3>
                                <h6>Total Order</h6>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/today/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->whereDate('created_at', \Illuminate\Support\Carbon::today())->count() }}</h3>
                            <h6>Today Order</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/pending/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'pending')->whereMonth('created_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Total Pending</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/today/pending/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'pending')->whereDate('created_at', \Illuminate\Support\Carbon::today())->get()->count() }}</h3>
                            <h6>Today Pending</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/hold/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'hold')->whereMonth('updated_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Total Hold</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/today/hold/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'hold')->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}</h3>
                            <h6>Today Hold</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/cancel/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'cancel')->whereMonth('updated_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Total Canceled</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/today/cancel/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'cancel')->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}</h3>
                            <h6>Today Cancelled</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/delivered/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'delivered')->whereMonth('updated_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Total Delivered</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/today/delivered/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'delivered')->where('pathao_order_status', null)->whereDate('updated_at', \Illuminate\Support\Carbon::today())->get()->count() }}</h3>
                            <h6>Today Delivered</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/return/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'return')->whereMonth('updated_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Return</h6>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <a href="{{url('/user/order-list/damage/'.$user->id)}}">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>{{ \App\Models\Order::where('employee_id', $user->id)->where('order_status', 'damage')->whereMonth('updated_at', \Illuminate\Support\Carbon::now()->month)->get()->count() }}</h3>
                            <h6>Damage</h6>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
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
