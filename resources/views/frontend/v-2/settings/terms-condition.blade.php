@extends('frontend.v-2.master')

@section('title')
    Terms & Conditions
@endsection

@section('content-v2')
    <section class="terms-conditions-section">
        <div class="section-heading-outer">
            <h4 class="section-heading-inner">
                Terms & Conditions
            </h4>
        </div>
        <div class="container">
            <div class="terms-conditions-content">
                <div class="contant-des">
                    {!! $terms?->terms_condition !!}
                </div>
            </div>
        </div>
    </section>
@endsection
