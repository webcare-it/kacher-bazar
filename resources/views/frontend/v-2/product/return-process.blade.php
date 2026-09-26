@extends('frontend.v-2.master')

@section('title')
    Product Return
@endsection

@section('content-v2')
<section class="product-page-banner-section">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="{{ url('/') }}">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li>
                Product Return Process
            </li>
        </ul>
    </div>
</section>
<section class="return-process-section" id="app">
    <div class="container">
        <div class="row">
            <div class="col-md-10 m-auto">
                <return-product-form></return-product-form>
            </div>
        </div>
    </div>
  </section>
@endsection
