@extends('frontend.v-2.master')

@section('title')
    Blogs
@endsection

@section('content-v2')
     <section class="bolgs-section-wrapper">
        <div class="privacy-policy-heading-wrapper">
            <div class="section-heading-outer">
                <h4 class="section-heading-inner">
                    Blog
                </h4>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <a href="{{ url('blog-details/'.$blog?->id) }}" class="bolg-item-wrapper">
                            <img src="{{ asset('/blogs/'.$blog?->image) }}" />
                            <h4 class="bolg-item-title">
                                {{ $blog?->title }}
                            </h4>
                            <p class="bolg-item-des">
                               {!! \Illuminate\Support\Str::limit(strip_tags($blog?->description, 200)) !!}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
