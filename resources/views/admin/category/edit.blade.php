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
                                    <h5 class="mb-1">Update category</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm radius-30">Categories</a>
                                </div>
                            </div>
                            <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" placeholder="Category name">
                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <img src="{{ asset('category/'.$category->image) }}" style="height: 80px; width: 90px;"/>
                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('name') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Banner Image</label>
                                    <input type="file" name="banner" class="form-control" />
                                    <img src="{{ asset('category/'.$category?->banner) }}" style="height: 80px; width: 90px;"/>
                                    <span style="color: red"> {{ $errors->has('banner') ? $errors->first('banner') : ' ' }}</span>
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
