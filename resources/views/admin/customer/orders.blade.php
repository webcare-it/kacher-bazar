@extends('admin.master')

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
                                    <form action="{{ url('/orders') }}" method="GET">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" name="search" class="form-control" placeholder="Search...">
                                            <button type="submit" class="input-group-text bg-primary text-white">Search</button>
                                            <a href="{{ url('/orders') }}" class="input-group-text bg-danger text-white">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="15%">Order ID</th>
                                           <th width="15%">Customer Name</th>
                                           <th width="20%">Qty</th>
                                           <th width="20%">Total Price</th>
                                           <th width="10%">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $order->orderId ?? 'No order id found' }}</td>
                                            <td>{{ $order->name?? 'No name found' }}</td>
                                            <td></td>
                                            <td>{{ $order->price }} Tk.</td>
                                            <td>
                                                @if($order->status == 0)
                                                    <a href="{{ url('/status/pending/' .$order->id) }}" class="btn btn-sm btn-danger">Pending</a>
                                                @elseif($order->status == 1)
                                                    <a href="{{ url('/status/shipping/' .$order->id) }}" class="btn btn-sm btn-warning">Shipping</a>
                                                @else
                                                    <a href="#" class="btn btn-sm btn-success">Complete</a>
                                                @endif
                                                <a href="{{ url('/order/view/' .$order->id) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
