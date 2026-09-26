@extends('frontend.v-2.master')

@section('title')
    Home
@endsection

@section('content-v2')
    <section class="home-slider-section container">
        <div class="slider-items-wrapper">
            @foreach($sliders as $slider)
            <div class="slider-item-outer">
                <img src="{{ asset('/setting/'.$slider->image) }}" alt="image">
            </div>
            @endforeach
        </div>
    </section>
    <!-- /Home Slider -->

    <!-- Categoris Slider -->
    <section class="categoris-slider-section">
        <div class="container">
            <div class="section-title-outer text-center">
                <h1 class="title">
                    Categories
                </h1>
            </div>
            <div class="categoris-items-wrapper owl-carousel">
                @foreach ($categories as $category)
                    <a href="{{ url('/products/'.$category->slug) }}" class="categoris-item">
                        <img src="{{ asset('/category/'.$category->image) }}" alt="category" />
                        <h6 class="categoris-name">{{ $category->name }}</h6>
                        <span class="items-number">{{ count($category->products) }} items</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /Categoris Slider -->

    <!-- Banner -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                @foreach($topBanners as $topBanner)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="banner-item-outer">
                            <img src="{{ asset('/setting/'.$topBanner->image) }}" alt="banner image" />
                            <div class="banner-content">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /Banner -->

    @php
        $hot_display = $hot_products->take(12);
        $new_display = $new_products->take(12);
        $regular_display = $regular_products->take(12);
        $discount_display = $discount_products->take(12);
    @endphp

    <!-- Best Selling Products -->
    @if(count($hot_products) > 0)
    <section class="product-section">
        <div class="container">
            <div class="section-title-outer" style="text-align: center;">
                <h1 class="title" style="display: inline-block; margin: 0 auto;">
                    Best Selling Products
                </h1>
            </div>
            <div class="row">
                @foreach ($hot_display as $product)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    @include('frontend.v-2.includes.product-card')
                </div>
                @endforeach
            </div>
            @if(count($hot_products) > 12)
            <div class="see-more-wrapper">
                <a href="{{ url('/hot/products') }}" class="see-more-btn">
                    See More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>
    <!-- /Best Selling Products -->
    @endif

    <!-- New Arrival -->
    @if(count($new_products) > 0)
    <section class="product-section">
        <div class="container">
            <div class="section-title-outer text-center">
                <h1 class="title">
                    New Arrival
                </h1>
            </div>
            <div class="row">
                @foreach ($new_display as $product)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    @include('frontend.v-2.includes.product-card')
                </div>
                @endforeach
            </div>
            @if(count($new_products) > 12)
            <div class="see-more-wrapper">
                <a href="{{ url('/new-arrival/products') }}" class="see-more-btn">
                    See More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>
    <!-- /New Arrival -->
    @endif

    <!-- Regular Products -->
    @if(count($regular_products) > 0)
    <section class="product-section">
        <div class="container">
            <div class="section-title-outer text-center">
                <h1 class="title">
                    Regular Products
                </h1>
            </div>
            <div class="row">
                @foreach ($regular_display as $product)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    @include('frontend.v-2.includes.product-card')
                </div>
                @endforeach
            </div>
            @if(count($regular_products) > 12)
            <div class="see-more-wrapper">
                <a href="{{ url('/feature/products') }}" class="see-more-btn">
                    See More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>
    <!-- /Regular Products -->
    @endif

    <!-- Discount Products -->
    @if(count($discount_products) > 0)
    <section class="product-section">
        <div class="container">
            <div class="section-title-outer text-center">
                <h1 class="title">
                    Discount Products
                </h1>
            </div>
            <div class="row">
                @foreach ($discount_display as $product)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    @include('frontend.v-2.includes.product-card')
                </div>
                @endforeach
            </div>
            @if(count($discount_products) > 12)
            <div class="see-more-wrapper">
                <a href="{{ url('/discount/products') }}" class="see-more-btn">
                    See More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </section>
    <!-- /Discount Products -->
    @endif

    <style>
        .see-more-wrapper {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .see-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 40px;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            background: var(--primary);
            border: none;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            letter-spacing: 0.5px;
        }
        .see-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: #fff;
            text-decoration: none;
        }
        .see-more-btn i {
            font-size: 13px;
            transition: transform 0.3s ease;
        }
        .see-more-btn:hover i {
            transform: translateX(4px);
        }
    </style>
@endsection
