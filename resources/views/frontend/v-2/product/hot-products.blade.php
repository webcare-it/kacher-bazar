@extends('frontend.v-2.master')

@section('title')
    Hot Products
@endsection

@section('content-v2')
    <section class="product-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-page-header-wrapper">
                        <div class="left-side-box">
                            <h4 class="title">
                                Hot Products
                            </h4>
                        </div>
                        <div class="right-side-box">
                            <h4 class="product-qty">
                                Total Products
                                <span class="number">{{ $products->total() }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                @foreach ($products as $product)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                        <div class="product-item-wrapper">
                            <div class="product-image-outer">
                                @if ($product->is_variable == true)
                                    <a href="{{ url('variable-product/' . $product->slug) }}" class="product-imgae">
                                    @else
                                        <a href="{{ url('product/' . $product->slug) }}" class="product-imgae">
                                @endif
                                <img src="{{ asset('product/images/' . $product->image) }}" class="main-image"
                                    alt="product image">
                                </a>
                                <div class="product-badges hot">
                                    <span style="text-transform: capitalize">{{ $product->product_type }}</span>
                                </div>
                            </div>
                            <div class="product-content-outer">
                                @if ($product->is_variable == true)
                                    <a href="{{ url('variable-product/' . $product->slug) }}" class="product-name">
                                    @else
                                        <a href="{{ url('product/' . $product->slug) }}" class="product-name">
                                @endif
                                {{ mb_strlen($product->name, 'UTF-8') > 50 ? mb_substr($product->name, 0, 50, 'UTF-8') . '....' : $product->name }}
                                </a>
                                <div class="product-item-bottom">
                                    <div class="product-price">
                                        @if ($product->discount_price != null)
                                            <span>{{ $product->discount_price }} Tk.</span>
                                            <span
                                                style="text-decoration: line-through; color: #999; font-size: 12px; margin-left: 5px;">{{ $product->regular_price }}
                                                Tk.</span>
                                        @else
                                            <span>{{ $product->regular_price }} Tk.</span>
                                        @endif
                                    </div>
                                    <div class="add-cart">
                                        <a href="{{ url('/add/to/cart/' . $product->id . '/add_cart') }}" class="add-cart-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add
                                        </a>
                                    </div>
                                </div>
                                @if ($product->is_variable == true)
                                    <a href="{{ url('variable-product/' . $product->slug) }}"
                                        class="quick-order-btn-inner">Quick Order</a>
                                @else
                                    <a href="{{ url('/add/to/cart/' . $product->id . '/quick_order') }}"
                                        class="quick-order-btn-inner">Quick Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
