@extends('frontend.v-2.master')

@section('title')
{{ $categoryProducts->name }}
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
                    {{ $categoryProducts?->name }} Products
                </li>
            </ul>
        </div>
    </section>
    <section class="product-section">
        <div class="container">
            <div class="row">
                @foreach ($categoryProducts->products as $product)
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="product-item-wrapper">
                        <div class="product-image-outer">
                            @if ($product->is_variable == true)
                            <a href="{{url('variable-product/'.$product->slug)}}" class="product-imgae">
                            @else
                            <a href="{{url('product/'.$product->slug)}}" class="product-imgae">
                            @endif
                                <img src="{{asset('product/images/'.$product->image)}}" class="main-image" alt="product image">
                            </a>
                            <div class="product-badges hot">
                                <span style="text-transform: capitalize">{{$product->product_type}}</span>
                            </div>
                        </div>
                        <div class="product-content-outer">
                            @if ($product->is_variable == true)
                            <a href="{{url('variable-product/'.$product->slug)}}" class="product-name">
                            @else
                            <a href="{{url('product/'.$product->slug)}}" class="product-name">
                            @endif
                                {{mb_strlen($product->name, 'UTF-8') > 50 ? mb_substr($product->name, 0, 50, 'UTF-8') . '....' : $product->name}}
                            </a>
                            <div class="product-item-bottom">
                                <div class="product-price">
                                    @if ($product->discount_price != null)
                                    <span>{{$product->discount_price}} Tk.</span>
                                    @else
                                    <span>{{$product->regular_price}} Tk.</span>
                                    @endif
                                </div>
                                <div class="add-cart">
                                    <a href="{{url('/add/to/cart/'.$product->id.'/add_cart')}}" class="add-cart-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        Add
                                    </a>
                                </div>
                            </div>
                            @if ($product->is_variable == true)
                            <a href="{{url('variable-product/'.$product->slug)}}" class="quick-order-btn-inner">Quick Order</a>
                            @else
                            <a href="{{url('/add/to/cart/'.$product->id.'/quick_order')}}" class="quick-order-btn-inner">Quick Order</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('script')
@endpush
