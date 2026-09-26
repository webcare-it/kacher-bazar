@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <span style="font-weight: 500; font-size: 25px; color: black">Check Purchase Report</span>
                                    <form method="GET" action="#" class="form-inline mb-3">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-gradient-blues">From</span>
                                            <input type="date" class="form-control" name="from" placeholder="From date" aria-label="Username">
                                            <span class="input-group-text bg-gradient-burning">To</span>
                                            <input type="date" class="form-control" name="to" placeholder="To date" aria-label="Server">
                                            <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Search</button>
                                            <a href="{{ url('/purchase') }}" class="btn btn-sm btn-danger"><i class="fa fa-search"></i> Clear</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            @if(Session::has('success'))
                                <x-alert :message="session('success')" title="Success" type="success"></x-alert>
                            @endif
                            @if(Session::has('error'))
                                <x-alert :message="session('error')" title="Error" type="error"></x-alert>
                            @endif

                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Purchase Products</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/purchase/create') }}" class="btn btn-primary btn-sm">Add Purchase</a>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th width="5%">SL</th>
                                        <th width="10%">Customer Name</th>
                                        <th width="10%">Product Name</th>
                                        <th width="10%">Per Price</th>
                                        <th width="10%">Total Price</th>
                                        <th width="10%">Qty</th>
                                        <th width="10%" class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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
