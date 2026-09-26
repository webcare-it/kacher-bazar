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
                            <h5 class="mb-1 text-white">Reason of {{$order_status}}</h5>
                            {{-- <a href="{{ url('/admin/customer/review') }}" class="btn btn-sm btn-primary float-end" style="margin-top: -25px;">Review List</a> --}}
                        </div>
                        <div class="card-body">
                            @if ($order_status == 'hold')
                                <form action="{{ url('/status/hold') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            @elseif ($order_status == 'cancel')
                                <form action="{{ url('/status/cancel') }}" method="post" enctype="multipart/form-data">
                                @csrf
                            @endif
                                <div class="form-group">
                                    <label>Reason</label>
                                    <textarea class="form-control" name="notes" rows="6" placeholder="Enter Message" required></textarea>
                                    <span style="color: red"> {{ $errors->has('notes') ? $errors->first('notes') : ' ' }}</span>
                                </div>
                                <input type="hidden" name="orderId" value="{{$orderId}}">
                                <input type="hidden" name="order_status" value="{{$order_status}}">
                                <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
