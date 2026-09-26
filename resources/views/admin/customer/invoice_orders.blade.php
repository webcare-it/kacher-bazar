@extends('admin.master')

@include('admin.includes.action-css')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
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
                                    <form action="{{ url('/invoice') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search orderId and Customer phone...">
                                            <button type="submit"
                                                class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/invoice') }}"
                                                class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="row">

                                {{-- <div class="col-md-4">
                                    @if (session('name') == 'admin')
                                    <form action="{{ url('/invoice')}}" method="get" class="user-form form-group mb-3">
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
                                    @endif
                                </div> --}}

                                {{-- <div class="col-md-8">
                                    <form method="GET" action="{{ url('/invoice') }}" class="form-inline mb-3">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-gradient-blues">From</span>
                                            <input type="date" class="form-control" name="from" placeholder="From date" aria-label="Username">
                                            <span class="input-group-text bg-gradient-burning">To</span>
                                            <input type="date" class="form-control" name="to" placeholder="To date" aria-label="Server">
                                            <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Search</button>
                                            <a href="{{ url('/invoice') }}" class="btn btn-sm btn-danger"><i class="fa fa-search"></i> Clear</a>
                                        </div>
                                    </form>
                                </div> --}}
                            </div>

                            <form action="{{ url('/process-selected-orders') }}" method="post">
                                @csrf
                                {{-- @include('admin.includes.action-button') --}}
                                <input type="button" onclick='selects()' value="Select All" class="btn btn-sm btn-success float-left"/>
                                <input type="button" onclick='deSelect()' value="Unselect All" class="btn btn-sm btn-secondary float-left" style="margin-left: 10px"/>
                                <button type="submit" id="submit-btn" name="submit_button" value="print" class="btn btn-sm btn-info float-right mr-2" style="cursor: pointer">Print</button>
                                <button type="submit" id="submit-btn-csv" name="submit_button" value="csv" class="btn btn-sm btn-warning float-right mr-2" style="cursor: pointer">Download CSV</button>
                                {{-- @if(isset(request()->id)) --}}
                                {{-- <a href="{{ url('/download/order-csv/43') }}" class="btn btn-sm btn-warning" style="margin-left: 10px; width: 120px;">Download CSV</a> --}}
                                {{-- @endif --}}
                                <div class="mt-3">
                                    <table class="table table-striped table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">Select</th>
                                                <th width="5%">SL</th>
                                                <th width="5%">Ds Order?</th>
                                                <th width="15%">Order ID</th>
                                                <th width="15%">Customer</th>
                                                <th width="15%">Product</th>
                                                <th width="15%">Courier</th>
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
                                                        <input type="checkbox" name="id[]" id="id{{ $order->id }}" value="{{ $order->id }}" />
                                                    </td>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @if ($order->is_dropshipping==true)
                                                            <span class="badge rounded-pill bg-success">Yes</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-warning">No</span>
                                                        @endif
                                                    </td>
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
                                                            {{ 'Size: ' . $details->size?? '' }} | {{ 'Color: ' . $details->color?? '' }}
                                                        @endforeach
                                                    </td>
                                                    @if ($order->courier_name == 'Pathao')
                                                    <td>{{$order->courier_name??'Not Selected'}}>{{$order->pathao_city_name??'Not Selected'}}>{{$order->pathao_zone_name??'Not Selected'}}</td>
                                                    @elseif ($order->courier_name == 'Others')
                                                    <td>
                                                        <textarea name="" id="" cols="20" rows="5" readonly>{{$order->otherCourierDetails?? 'Not Any'}}</textarea>
                                                    </td>
                                                    @else
                                                    <td>Not Selected</td>
                                                    @endif
                                                    <td>
                                                        <b>Amount :</b> {{ $order->price }} Tk. <br />
                                                        <b>Delivery :</b> {{ $order->area }} Tk.
                                                    </td>
                                                    <td>
                                                        <div class="action-dropdown-menu">
                                                            <a href="javascript:;" class="action-dropdown-link">
                                                                {{-- {{ucfirst($order->order_status)}} --}}
                                                                Pending Invoiced
                                                            </a>
                                                            <ul class="action-btn-list">
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/invoice-checked/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Invoice Checked
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/invoiced/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Invoiced
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/stock-out/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Stock Out
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/schedule-delivery/form/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Schedule Delivery
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/status/cancel/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Cancel
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{ url('/order/delivered/status/' . $order->id) }}"
                                                                        class="action-btn-link">
                                                                        Delivered
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                    <td>{{ Str::ucfirst($order->admin?->name) }}</td>
                                                    <td>
                                                        @if ($order->is_dropshipping == true)
                                                        <a href="{{ url('/dropshipping-order/view/' . $order->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                        @else
                                                        <a href="{{ url('/order/view/' . $order->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $orders->links() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@include('admin.includes.action-button-js')
    <script>
        function selects(){
            var selec=document.getElementsByName('id[]');
            console.log(selec);
            for(var i=0; i<selec.length; i++){
                if(selec[i].type == 'checkbox')
                    selec[i].checked=true;
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
