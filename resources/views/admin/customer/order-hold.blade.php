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
                                    <h5 class="mb-1">Customer orders Hold</h5>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <form action="{{ url('/order/hold') }}" method="get">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search...">
                                        <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                        <a href="{{ url('/order/hold') }}" class="input-group-text bg-danger text-white">Clear</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form action="{{ url('/order/update') }}" method="post">
                            @csrf
                            @include('admin.includes.action-button')

                           <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">Select</th>
                                        <th width="5%">SL</th>
                                        <th width="5%">Ds Order?</th>
                                        <th width="15%">Order ID</th>
                                        <th width="15%">Customer</th>
                                        <th width="15%">Product</th>
                                        <th width="20%">Total</th>
                                        <th width="5%">Status</th>
                                        <th width="5%">Notes</th>
                                        <th width="10%">Date</th>
                                        <th width="20%">Users</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hold_orders as $key => $order)
                                    <tr>
                                        <td>
                                            @if($order->order_status != null)
                                                <input type="checkbox" name="id[]" id="id{{ $order->id }}" value="{{ $order->id }}" />
                                            @endif
                                        </td>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>
                                            @if ($order->is_dropshipping==true)
                                                <span class="badge rounded-pill bg-success">Yes</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info" style="font-size: 12px; color: black">{{env('APP_NAME')}}</span><br/>
                                            <span style="font-size: 16px; font-weight:600;">{{ $order->orderId ?? 'No order id found' }}</span><br/>
                                            <span class="badge rounded-pill bg-primary">{{ $order->order_type }}</span> <br/>
                                            {{ $order->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $order->name?? 'No name found' }}<br/>
                                            <span style="color: green">{{ $order->phone?? 'No phone found' }}</span><br/>
                                            {{ substr($order->address,0,70)?? 'No address found' }} <br/>
                                            <span class="badge rounded-pill {{ $order->customer_type == 'Old Customer' ? 'bg-danger' : 'bg-success' }}">{{ $order->customer_type }}</span> <br/>
                                        </td>
                                        <td>
                                            @foreach ($order->orderDetails as $details)
                                                {{ $order->qty?? 'No name found' }}X {{ $details->product?->name }}<br/>
                                                {{ 'Size: ' . $details->size?? '' }} | {{ 'Color: ' . $details->color?? '' }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <b>Amount :</b> {{ $order->price }} Tk. <br/>
                                            <b>Delivery :</b> {{ $order->area }} Tk.
                                        </td>
                                        <td>
                                            <div class="action-dropdown-menu">
                                                <a href="javascript:;" class="action-dropdown-link">
                                                    Hold
                                                </a>

                                            </div>
                                        </td>
                                        <td>
                                            <textarea name="" id="" cols="20" rows="5" readonly>{{$order->notes?? 'Not Any'}}</textarea>
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
        function deSelect(){
            var selec=document.getElementsByName('id[]');
            for(var i=0; i<selec.length; i++){
                if(selec[i].type == 'checkbox')
                    selec[i].checked=false;

            }
        }
    </script>
@endpush
