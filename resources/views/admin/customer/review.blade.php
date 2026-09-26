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
                            <h5 class="mb-1 text-white">Customer Review List</h5>
                            <a href="{{ url('/add/customer/review') }}" class="btn btn-sm btn-primary float-end" style="margin-top: -25px;">Add Review</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="table-hover">
                                            <th width="5%">SL</th>
                                            <th width="15%">Product Name</th>
                                            <th width="15%">Name</th>
                                            <th width="10%">Phone</th>
                                            <th width="5%">Rating</th>
                                            <th width="20%">Address</th>
                                            <th width="20%">Message</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productReviews as $productReview)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $productReview->product?->name }}</td>
                                                <td>{{ $productReview->name }}</td>
                                                <td>{{ $productReview->phone }}</td>
                                                <td>{{ $productReview->rating }}</td>
                                                <td>{{ $productReview->address }}</td>
                                                <td>{{ $productReview->message }}</td>
                                                <td>
                                                    <a href="{{ url('/admin/customer/review/edit/'.$productReview->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                    <a href="{{ url('/admin/customer/review/delete/'.$productReview->id) }}" class="btn btn-sm btn-danger">Delete</a>
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