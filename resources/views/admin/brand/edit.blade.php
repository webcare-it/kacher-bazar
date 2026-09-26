@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Update Brand</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('brands.index') }}" class="btn btn-primary btn-sm">Brand</a>
                                </div>
                            </div>
                            <form action="{{ route('brands.update', $brand->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $brand->name ?? old('name') }}" class="form-control" placeholder="Brand name">
                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <select class="form-control" name="cat_id" id="cat_id">
                                        <option selected disabled>Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $brand->cat_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red"> {{ $errors->has('cat_id') ? $errors->first('cat_id') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Subcategory Name</label>
                                    <select class="form-control" name="sub_cat_id" id="sub_cat_id">
                                        <option selected disabled>Select a Subcategory</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $subcategory->id == $brand->sub_cat_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red"> {{ $errors->has('sub_cat_id') ? $errors->first('sub_cat_id') : ' ' }}</span>
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
