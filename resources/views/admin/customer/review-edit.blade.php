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
                            <h5 class="mb-1 text-white">Customer Review edit</h5>
                            <a href="{{ url('/admin/customer/review') }}" class="btn btn-sm btn-primary float-end" style="margin-top: -25px;">Review List</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('/admin/customer/review/update/'.$productReview->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name*</label>
                                    <input type="text" name="name" value="{{ $productReview->name }}" class="form-control" placeholder="Customer name">
                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Select a product*</label>
                                    <select class="form-control" name="product_id">
                                        <option selected disabled>Select A Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ $productReview->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red"> {{ $errors->has('product_id') ? $errors->first('product_id') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Rating*</label>
                                    <input type="number" name="rating" value="{{ $productReview->rating }}" class="form-control" placeholder="Customer rating">
                                    <span style="color: red"> {{ $errors->has('rating') ? $errors->first('rating') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" value="{{ $productReview->phone }}" class="form-control" placeholder="Customer name">
                                    <span style="color: red"> {{ $errors->has('phone') ? $errors->first('phone') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" rows="4" placeholder="Enter address">{{ $productReview->address }}</textarea>
                                    <span style="color: red"> {{ $errors->has('address') ? $errors->first('address') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" name="message" rows="6" placeholder="Enter message">{{ $productReview->message }}</textarea>
                                    <span style="color: red"> {{ $errors->has('message') ? $errors->first('message') : ' ' }}</span>
                                </div>
                                <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
