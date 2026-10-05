<header class="header-section">
    <div class="container">
        <!-- Mobile Header -->
        <div class="mobile-header d-block d-lg-none">
            <div class="mobile-header-top">
                <div class="mobile-hamburger nav-toggle-btn" role="button">
                    <div class="btn-inner"></div>
                </div>
                <a href="{{ url('/') }}" class="mobile-brand-logo">
                    <img src="{{ asset('setting/'.$setting->logo) }}" alt="logo">
                </a>
                <div class="mobile-cart-icon">
                    <a href="{{ url('/user/cart/products') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="mobile-cart-count">{{$carts->count()}}</span>
                    </a>
                </div>
            </div>
            <div class="mobile-search-bar">
                <form action="{{url('/view/product/search')}}" method="GET">
                    <input type="text" name="search" placeholder="Search Product ..." class="form-control">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!-- Desktop Header -->
        <div class="header-top-wrapper d-none d-lg-flex">
            <a href="{{ url('/') }}" class="brand-logo-outer">
                <img src="{{asset('setting/'.$setting->logo)}}">
            </a>
            <div class="search-form-outer">
                <form action="{{url('/view/product/search')}}" method="GET" class="form-group search-form">
                    @csrf
                    <input type="text" name="search" class="form-control" placeholder="Search for items...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="header-top-right-outer">
                <div class="res-search-icon-outer">
                    <i class="fas fa-search"></i>
                </div>
                <div id="cart">
                    <div class="header-top-right-item dropdown">
                        <div class="header-top-right-item-link">
                            <span class="icon-outer">
                                <i class="fas fa-cart-plus"></i>
                                <span class="count-number">{{$carts->count()}}</span>
                            </span>
                            Cart
                        </div>
                        <div class="cart-items-wrapper">
                            <div class="cart-items-outer">
                                @foreach ($carts as $cart)
                                @if($cart->product)
                                <div class="cart-item-outer">
                                    <a href="#" class="cart-product-image">
                                        <img src="{{asset('product/images/'.$cart->product->image)}}" alt="product">
                                    </a>
                                    <div class="cart-product-name-price">
                                        <a href="#" class="product-name">
                                            {{$cart->product->name}}
                                        </a>
                                        <span class="product-price">
                                            ৳ {{$cart->price}}
                                        </span>
                                    </div>
                                    <div class="cart-item-delete">
                                        <a href="{{url('product/delete/form/cart/'.$cart->id)}}" class="delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="shopping-cart-footer">
                                <div class="shopping-cart-total">
                                    <h4>
                                        Total <span>৳ {{$carts->sum('price')}}</span>
                                    </h4>
                                </div>
                                <div class="shopping-cart-button">
                                    <a href="{{url('/user/cart/products')}}" class="view-cart-link">View cart</a>
                                    <a href="{{url('/checkout')}}" class="checkout-link">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-top-right-item dropdown account">
                    <ul class="account-list">
                        <li class="account-list-item">
                            @if (auth()->check())
                            <a href="{{ route('logout') }}" class="account-list-item-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-user"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                             </form>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Desktop Header -->

        <!-- Desktop Bottom Nav -->
        <div class="header-bottom-wrapper d-none d-lg-block">
            <div class="category-items-wrapper">
                <div class="category-icon-outer">
                    <i class="fas fa-th-large"></i> <span>All Category</span>
                </div>
                <div class="category-items-outer">
                    <ul class="category-list">
                        @foreach ($categories as $category)
                            <li class="category-list-item item-has-submenu">
                                <a href="{{ url('/products/'.$category->slug) }}" class="category-list-item-link">
                                    <img src="{{ asset('/category/'.$category->image) }}" alt="category">
                                    {{ $category->name }}
                                </a>
                                <ul class="nav-item-category-submenu">
                                    @foreach($category->subcategories as $subcategory)
                                        <li class="category-submenu-item">
                                            <a href="{{ url('/subcategory/products/'.$subcategory->slug) }}" class="category-submenu-item-link">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="header-bottom-nav">
                <ul class="header-bottom-nav-list">
                    <li class="header-bottom-nav-item">
                        <a href="{{ url('/') }}" class="header-bottom-nav-item-link">Home</a>
                    </li>
                    <li class="header-bottom-nav-item">
                        <a href="{{ url('/shops') }}" class="header-bottom-nav-item-link">Shop</a>
                    </li>
                    @foreach ($categories->take(5) as $category)
                        <li class="header-bottom-nav-item">
                            <a href="{{ url('/products/'.$category->slug) }}" class="header-bottom-nav-item-link">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            </div>
        </div>
        <!-- /Desktop Bottom Nav -->

        <!-- Mobile Side Menu -->
        <div class="mobile-side-menu-overlay d-lg-none"></div>
        <div class="mobile-side-menu d-lg-none">
            <div class="mobile-side-menu-header">
                <a href="{{ url('/') }}" class="mobile-side-menu-logo">
                    <img src="{{ asset('setting/'.$setting->logo) }}" alt="logo">
                </a>
                <button type="button" class="mobile-side-menu-close" aria-label="Close menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mobile-side-menu-body">
                <ul class="mobile-side-menu-list">
                    <li class="manu-list-item">
                        <a href="{{ url('/') }}" class="manu-list-item-link">
                            <span class="manu-list-item-icon"><i class="fas fa-home"></i></span>
                            Home
                        </a>
                    </li>
                    <li class="manu-list-item">
                        <a href="{{ url('/shops') }}" class="manu-list-item-link">
                            <span class="manu-list-item-icon"><i class="fas fa-store"></i></span>
                            Shop
                        </a>
                    </li>
                </ul>

                <h6 class="mobile-side-menu-title">Categories</h6>
                <ul class="mobile-side-menu-list">
                    @foreach ($categories as $category)
                        <li class="manu-list-item">
                            <div class="manu-list-item-row">
                                <a href="{{ url('/products/'.$category->slug) }}" class="manu-list-item-link">
                                    <span class="manu-list-item-icon">
                                        <img src="{{ asset('/category/'.$category->image) }}" alt="{{ $category->name }}">
                                    </span>
                                    {{ $category->name }}
                                </a>
                                @if ($category->subcategories->count())
                                    <button type="button" class="mobile-submenu-toggle" aria-label="Show subcategories">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                @endif
                            </div>
                            @if ($category->subcategories->count())
                                <ul class="mobile-submenu">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{ url('/subcategory/products/'.$subcategory->slug) }}">{{ $subcategory->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- /Mobile Side Menu -->

        <!-- Mobile Bottom Nav -->
        <div class="mobile-bottom-nav d-lg-none">
            <a href="javascript:void(0)" class="mobile-bottom-nav-item nav-toggle-btn">
                <i class="fas fa-bars"></i>
                <span>Category</span>
            </a>
            <a href="https://wa.me/+88{{ $setting->phone ?? '' }}" target="_blank" class="mobile-bottom-nav-item">
                <i class="fab fa-whatsapp"></i>
                <span>Message</span>
            </a>
            <a href="{{ url('/') }}" class="mobile-bottom-nav-item mobile-bottom-nav-home">
                <div class="mobile-bottom-nav-home-icon">
                    <i class="fas fa-home"></i>
                </div>
                <span>Home</span>
            </a>
            <a href="{{ url('/user/cart/products') }}" class="mobile-bottom-nav-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart <small>({{ $carts->count() }})</small></span>
            </a>
            <a href="tel:{{ $setting->phone ?? '' }}" class="mobile-bottom-nav-item">
                <i class="fas fa-phone-alt"></i>
                <span>Call</span>
            </a>
        </div>
        <!-- /Mobile Bottom Nav -->
    </div>
</header>
