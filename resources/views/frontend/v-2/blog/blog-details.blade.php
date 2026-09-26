@extends('frontend.v-2.master')

@section('title')
    Blog Details
@endsection

@section('content-v2')
    <section class="blog-details-banner-section">
        <div class="blog-details-banner-bg-image">
            <img src="{{ asset('/frontend/') }}/assets/images/aboutus-banner.jpg">
        </div>
        <div class="blog-details-banner-content">
            <h3 class="blog-details-banner-content-title">
                Blog Details
            </h3>
        </div>
    </section>
    <section class="blog-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 m-auto">
                    <div class="blog-details-wrapper card">
                        @if($blogDetails)
                            <div class="blog-details-image-outer">
                                <img src="{{ asset('/blogs/'.$blogDetails->image) }}" />
                            </div>
                            <div class="blog-details-content">
                                <h4 class="bolg-title">
                                    {{ $blogDetails->title }}
                                </h4>
                                <p class="blog-des">
                                    {!! $blogDetails->description !!}
                                </p>
                            </div>
                        @else
                            <div class="blog-details-content">
                                <h4 class="bolg-title">Blog not found</h4>
                                <p class="blog-des">The requested blog post could not be found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
