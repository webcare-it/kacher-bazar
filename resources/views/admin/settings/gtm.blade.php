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

                            <form action="{{ route('admin.gtm.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="gtm_code" style="font-size: 18px;">Google Tag Manager Code (e.g. GTM-XXXXXXX)</label>
                                    <input type="text" class="form-control" name="gtm_id" id="gtm_id"
                                           value="{{ $code->gtm_id ?? old('gtm_id') }}" placeholder="GTM-XXXXXXX">
                                </div>

                                <button type="submit" class="btn btn-success mt-2 float-right">Save GTM Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
