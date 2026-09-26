@php
    $avgRating = $product->reviews->count() > 0 ? $product->reviews->avg('rating') : 0;
@endphp
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
        @if($avgRating > 0)
        <div class="product-rating">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($avgRating))
                    <i class="fas fa-star"></i>
                @elseif($i - $avgRating < 1 && $i - $avgRating > 0)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
            <span class="rating-count">({{ $product->reviews->count() }})</span>
        </div>
        @endif
        <div class="product-item-bottom">
            <div class="product-price">
                @if ($product->discount_price != null)
                <span>{{$product->discount_price}} Tk.</span>
                <span style="text-decoration: line-through; color: #999; font-size: 12px; margin-left: 5px;">{{$product->regular_price}} Tk.</span>
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
