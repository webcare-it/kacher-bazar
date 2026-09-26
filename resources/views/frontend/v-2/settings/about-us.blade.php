@extends('frontend.v-2.master')

@section('title')
    About us
@endsection

@section('content-v2')
    <section class="privacy-policy-section">
        <div class="privacy-policy-heading-wrapper">
            <div class="section-heading-outer">
                <h4 class="section-heading-inner">
                    About US
                </h4>
            </div>
        </div>
        <div class="container">
            <div class="privacy-policy-content">
                <div class="contant-des">
                    {!! $about?->about !!}
                </div>
            </div>
        </div>
    </section>
@endsection
