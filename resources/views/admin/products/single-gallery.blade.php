@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-3">Update Gallery Image</h5>
                                </div>
                                <div class="ms-auto">
                                    @if ($product->is_variable)
                                        <a href="{{ url('/variable-products/edit/' . $galleryImage->product_id . '/' . $productslug) }}" class="btn btn-primary btn-sm">Cancel</a>
                                    @else
                                        <a href="{{ url('/products/edit/' . $galleryImage->product_id . '/' . $productslug) }}" class="btn btn-primary btn-sm">Cancel</a>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ url('/gallery-image/update/'.$galleryImage->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($product->is_variable)
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Gallery Image <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="image" id="image" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Retail Price</label>
                                                    <input type="text" name="price" id="price" value="{{ $galleryImage->price }}" class="form-control" placeholder="Price">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="color" class="form-label">Color</label>
                                                    <input type="text" name="color" id="color" class="form-control" value="{{ $galleryImage->color }}" placeholder="Product color">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="size" class="form-label">Size</label>
                                                    <input type="text" name="size" id="size" class="form-control" value="{{ $galleryImage->size }}" placeholder="Product size">
                                                </div>
                                            @else
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Gallery Image <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="image" id="image" class="form-control" required>
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label>Current Image:</label><br>
                                                <img src="{{ asset('galleryImage/'.$galleryImage->gallery_image) }}" height="100" width="100" />
                                            </div>
                                        </div>
                                    </div>
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
