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

                            <form action="{{ url('/admin/update/credentials') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Email
                                                            <small style="color: red; font-size: 18px;">*</small></label>
                                                        <input type="text" name="email"
                                                            value="{{ $credential->email }}" class="form-control"
                                                            readonly><br>
                                                        <span style="color: red">
                                                            {{ $errors->has('email') ? $errors->first('email') : ' ' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">New
                                                            Password <small
                                                                style="color: red; font-size: 18px;">*</small></label>
                                                        <input type="text" name="password"
                                                            class="form-control"
                                                            placeholder="Enter password" required><br>
                                                        <span style="color: red">
                                                            {{ $errors->has('password') ? $errors->first('password') : ' ' }}</span>
                                                    </div>
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
