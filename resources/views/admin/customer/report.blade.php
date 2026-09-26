@extends('admin.master')

@push('style')

@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-header bg-gradient-burning">
                            <h5 class="mb-1 text-white">Order report</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="GET" action="{{ route('customer.products.order.report') }}" class="form-inline mb-3">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-gradient-blues">From</span>
                                            <input type="date" class="form-control" name="from" placeholder="From date" aria-label="Username">
                                            <span class="input-group-text bg-gradient-burning">To</span>
                                            <input type="date" class="form-control" name="to" placeholder="To date" aria-label="Server">
                                            <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Search</button>
                                            <a href="{{ url('/order/report') }}" class="btn btn-sm btn-danger"><i class="fa fa-search"></i> Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr class="table-hover">
                                           <th width="5%">SL</th>
                                           <th width="15%">Product Name</th>
                                           <th width="20%">Qty</th>
                                           <th width="20%">Total Price</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($ordersReports as $ordersReport)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ substr($ordersReport->product->name, 0, 35) ?? '' }}</td>
                                            <td>{{ $ordersReport->qty }}</td>
                                            <td>{{ $ordersReport->price * $ordersReport->qty ?? 0 }} Tk.</td>
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

@push('script')

@endpush
