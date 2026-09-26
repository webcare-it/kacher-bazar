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
                                        <h5 class="mb-1">Today orders</h5>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <form action="{{ url('/order/pending') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search orderId or Customer phone...">
                                            <button type="submit"
                                                class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/order/pending') }}"
                                                class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        @if (session('name') == 'admin')
                                        <form action="{{ url('/order/pending')}}" method="get" class="user-form form-group mb-3">
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
                                    </div>
                                    <div class="col-md-8">
                                        <form method="GET" action="{{ url('/order/pending') }}"
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
                                                <a href="{{ url('/order/pending') }}" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-search"></i> Clear</a>
                                            </div>
                                        </form>
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
                                                <th width="5%">DS Order?</th>
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
                                                        @if($order->order_status != null)
                                                            <input type="checkbox" name="id[]" id="id{{ $order->id }}" value="{{ $order->id }}" />
                                                        @endif
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
                                                    <td>
                                                        <b>Amount :</b> {{ $order->price }} Tk. <br />
                                                        <b>Delivery :</b> {{ $order->area }} Tk.
                                                    </td>
                                                    <td>
                                                        <div class="action-dropdown-menu">
                                                            <a href="javascript:;" class="action-dropdown-link">
                                                                {{ucfirst($order->order_status)}}
                                                            </a>
                                                            <ul class="action-btn-list">
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{url('/status/hold/form/'.$order->id)}}" class="action-btn-link">
                                                                        On Hold
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{url('/status/pending-payment/'.$order->id)}}" class="action-btn-link">
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
                                                                    <a href="{{url('/status/cancel/form/'.$order->id)}}" class="action-btn-link">
                                                                        Cancel
                                                                    </a>
                                                                </li>
                                                                <li class="action-btn-list-item">
                                                                    <a href="{{url('/status/complete/'.$order->id)}}" class="action-btn-link">
                                                                        Complete
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function addclass() {
            var element = document.getElementById("user");
            element.classList.toggle("show");
        }

        $('.action-dropdown-link').click(function(event) {
            event.stopPropagation();
            let thisList = $(this).closest('.action-dropdown-menu');
            $('.action-dropdown-menu').not(thisList).removeClass('active');
            thisList.toggleClass('active');
        });
        $(".action-dropdown-menu").on("click", function(event) {
            event.stopPropagation();
        });

        $(document).on("click", function() {
            $(".action-dropdown-menu").removeClass('active');
        });
    </script>

<script>
    function selects(){
        var selec=document.getElementsByName('id[]');
        console.log(selec);
        for(var i=0; i<selec.length; i++){
            if(selec[i].type == 'checkbox')
                selec[i].checked=true;
        }
    }
    function deSelect(){
        var selec=document.getElementsByName('id[]');
        for(var i=0; i<selec.length; i++){
            if(selec[i].type == 'checkbox')
                selec[i].checked=false;

        }
    }
</script>
@endpush
