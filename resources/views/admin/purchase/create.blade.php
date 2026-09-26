@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col" id="app">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Purchase Create</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('/purchase') }}" class="btn btn-primary btn-sm">Manage Purchase</a>
                                </div>
                            </div>
                            <purchase-input-field></purchase-input-field>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
