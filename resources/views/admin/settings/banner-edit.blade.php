@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            @if(Session::has('success'))
                                <x-alert :message="session('success')" title="Success" type="success"></x-alert>
                            @endif
                            @if(Session::has('error'))
                                <x-alert :message="session('error')" title="Error" type="error"></x-alert>
                            @endif
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Edit banner</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/banner/list') }}" class="btn btn-primary btn-sm radius-30">Back</a>
                                </div>
                            </div>
                            <form action="{{ url('/banner/update/'.$banner->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Banner type</label>
                                    <select class="form-control" name="type">
                                        <option selected disabled>Select A Banner Type</option>
                                        <option value="top" {{ $banner->type == 'top' ? 'selected' : '' }}>Top Banner</option>
                                        <option value="footer" {{ $banner->type == 'footer' ? 'selected' : '' }}>Bottom Banner</option>
                                    </select>
                                    <span style="color: red"> {{ $errors->has('type') ? $errors->first('type') : ' ' }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" />
                                    <img src="{{ asset('/setting/'.$banner->image) }}" height="100" width="100" alt="banner image" />
                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
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
