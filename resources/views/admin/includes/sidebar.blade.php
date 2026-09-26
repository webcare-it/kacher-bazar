<ul class="metismenu" id="menu">
    @if (session('name') === 'admin')
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>
            <div class="menu-title">Category</div>
        </a>
        <ul>
            <li> <a href="{{ route('categories.index')}}"><i class="bx bx-right-arrow-alt"></i>Lists</a></li>
            <li> <a href="{{ route('categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Add new</a></li>
        </ul>
    </li>
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>
            <div class="menu-title">Subcategory</div>
        </a>
        <ul>
            <li> <a href="{{ route('subcategories.index')}}"><i class="bx bx-right-arrow-alt"></i>Lists</a></li>
            <li> <a href="{{ route('subcategories.create')}}"><i class="bx bx-right-arrow-alt"></i>Add new</a></li>
        </ul>
    </li>
    <li>
        <a class="" href="{{ url('/page/list') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Add Page
            </div>
        </a>
    </li>
{{--    <li>--}}
{{--        <a class="has-arrow" href="javascript:;">--}}
{{--            <div class="parent-icon"><i class='bx bx-message-square-edit'></i></div>--}}
{{--            <div class="menu-title">Brands</div>--}}
{{--        </a>--}}
{{--        <ul>--}}
{{--            <li> <a href="{{ route('brands.index') }}"><i class="bx bx-right-arrow-alt"></i>Lists</a></li>--}}
{{--            <li> <a href="{{ route('brands.create') }}"><i class="bx bx-right-arrow-alt"></i>Add new</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-cart-alt'></i>
            </div>
            <div class="menu-title">
                Product
            </div>
        </a>
        <ul>
            <li>
                <a href="{{ route('products.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Product Lists
                </a>
            </li>
            <li>
                <a href="{{ route('products.dropshipping') }}">
                    <i class="bx bx-right-arrow-alt"></i>Dropshipping Product Lists
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.create') }}">
                    <i class="bx bx-right-arrow-alt"></i>Add Own Product
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/variable-products/create') }}">
                    <i class="bx bx-right-arrow-alt"></i>Add Own Variable Product
                </a>
            </li>

            <li>
                <a href="{{ route('admin.dropshipping-products.create') }}">
                    <i class="bx bx-right-arrow-alt"></i>Add Dropshipping Product
                </a>
            </li>

            <li>
              <a href="{{ route('admin.page.products.create') }}">
                  <i class="bx bx-right-arrow-alt"></i>Page Product Add
              </a>
            </li>
            <li>
                <a href="{{ route('page.products.index') }}">
                    <i class="bx bx-right-arrow-alt"></i>Page Product Lists
                </a>
            </li>
{{--            <li>--}}
{{--                <a href="{{ url('/stocks') }}">--}}
{{--                    <i class="bx bx-right-arrow-alt"></i>Stock--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ url('/orders') }}">--}}
{{--                    <i class="bx bx-right-arrow-alt"></i>Order(s)--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </li>
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-cart-alt'></i>
            </div>
            <div class="menu-title">
                Stock
            </div>
        </a>
        <ul>
            <li>
                <a href="{{ url('/stocks') }}">
                    <i class="bx bx-right-arrow-alt"></i>Stock Management
                </a>
            </li>
        </ul>
    </li>
    @endif
    <!-- <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class='bx bx-group'></i></div>
            <div class="menu-title">Customers</div>
        </a>
        <ul>
            <li> <a href="{{ url('/supplier/list') }}"><i class="bx bx-right-arrow-alt"></i>Suppliers</a></li>
            <li> <a href="{{ url('/customer/list') }}"><i class="bx bx-right-arrow-alt"></i>Users</a></li>
        </ul>
    </li> -->
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-cart-alt'></i>
            </div>
            <div class="menu-title">
                Orders
            </div>
        </a>
        <ul>
            <li>
                <a class="" href="{{ url('/order/add-manually') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Manual Order
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/cancel') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Order Cancel
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/hold') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Order Hold
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/pending') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Order Pending
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/delivery') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Order Delivered
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/pending-payment') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Pending Payment
                    </div>
                </a>
            </li>
            {{-- <li>
                <a class="" href="{{ url('/order/report') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Order report
                    </div>
                </a>
            </li> --}}
            <li>
                <a class="" href="{{ url('/all-orders') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        All Order
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/transferred-orders') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Transferred Orders
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/deleted/order') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Deleted Order
                    </div>
                </a>
            </li>

            <li>
                <a class="" href="{{ url('/order/return/list') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Return
                    </div>
                </a>
            </li>

            <li>
                <a class="" href="{{ url('/order/damage/list') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Damage
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/order/missing/list') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Missing
                    </div>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a class="" href="{{ url('/invoice') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Invoice
            </div>
        </a>
    </li>
    @if (session('name') == 'admin')
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-cart-alt'></i>
            </div>
            <div class="menu-title">
                Accounts
            </div>
        </a>
        <ul>
            <li>
                <a class="" href="{{ url('/expenses') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Expenses
                    </div>
                </a>
            </li>
            <li>
                <a class="" href="{{ url('/payment-reports') }}">
                    <div class="parent-icon">
                        <i class='bx bx-group'></i>
                    </div>
                    <div class="menu-title">
                        Payment Reports
                    </div>
                </a>
            </li>
        </ul>
    </li>
    @endif
    <li>
        <a class="" href="{{ url('/admin/customer/review') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Review
            </div>
        </a>
    </li>

    {{-- <li>
        <a class="" href="{{ url('/all-orders') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                All Order
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/order/cancel') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Order Cancel
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/order/hold') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Order Hold
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/order/pending') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Order Pending
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/complete/order') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Order Complete
            </div>
        </a>
    </li> --}}
    <!--<li>-->
    <!--    <a class="" href="{{ url('/order/report') }}">-->
    <!--        <div class="parent-icon">-->
    <!--            <i class='bx bx-group'></i>-->
    <!--        </div>-->
    <!--        <div class="menu-title">-->
    <!--            Order report-->
    <!--        </div>-->
    <!--    </a>-->
    <!--</li>-->

    @if (session('name') === 'admin')
    <li>
        <a class="" href="{{ url('/users') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Users
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/user/assign') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                User Assign
            </div>
        </a>
    </li>
    <li>
        <a class="" href="{{ url('/contacts') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Contacts
            </div>
        </a>
    </li>
    {{-- <li>
        <a class="" href="{{ url('/customer/return/list') }}">
            <div class="parent-icon">
                <i class='bx bx-group'></i>
            </div>
            <div class="menu-title">
                Customer Return Products
            </div>
        </a>
    </li> --}}
{{--    <li>--}}
{{--        <a class="" href="{{ url('/purchase') }}">--}}
{{--            <div class="parent-icon">--}}
{{--                <i class='bx bx-group'></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">--}}
{{--                Purchase--}}
{{--            </div>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <a class="" href="{{ url('/pos') }}">--}}
{{--            <div class="parent-icon">--}}
{{--                <i class='bx bx-group'></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">--}}
{{--                POS--}}
{{--            </div>--}}
{{--        </a>--}}
{{--    </li>--}}
    {{-- <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-message-detail'></i>
            </div>
            <div class="menu-title">
                Attributes
            </div>
        </a>
        <ul>
            <li>
                <a href="{{ url('/colors') }}">
                    <i class="bx bx-right-arrow-alt"></i>Colors
                </a>
            </li>
            <li>
                <a href="{{ url('/sizes') }}">
                    <i class="bx bx-right-arrow-alt"></i>Sizes
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bx-dollar-circle'></i>
            </div>
            <div class="menu-title">
                Payments
            </div>
        </a>
        <ul>
            <li>
                <a href="#"><i class="bx bx-right-arrow-alt"></i>Suppliers
                </a>
            </li>
            <li>
                <a href="#"><i class="bx bx-right-arrow-alt"></i>Users
                </a>
            </li>
        </ul>
    </li> --}}
    <hr/>
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bxs-cog'></i>
            </div>
            <div class="menu-title">
                Droploo Product
            </div>
        </a>
        <ul>
            <li>
                <a href="{{ url('/droploo-products') }}">
                    <i class="bx bx-right-arrow-alt"></i>List
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon">
                <i class='bx bxs-cog'></i>
            </div>
            <div class="menu-title">
                Settings
            </div>
        </a>
        <ul>
            <li>
                <a href="{{ url('/admin/show/credentials') }}">
                    <i class="bx bx-right-arrow-alt"></i>Change Credentials
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/gtm') }}">
                    <i class="bx bx-right-arrow-alt"></i>Google Tag manager
                </a>
            </li>
            <li>
                <a href="{{ url('/slider/list') }}">
                    <i class="bx bx-right-arrow-alt"></i>Slider
                </a>
            </li>
            <li>
                <a href="{{ url('/settings') }}">
                    <i class="bx bx-right-arrow-alt"></i>Setting
                </a>
            </li>
            <li>
                <a href="{{ url('/banner/add') }}">
                    <i class="bx bx-right-arrow-alt"></i>Banners
                </a>
            </li>
            <li>
                <a href="{{ url('/blog/list') }}">
                    <i class="bx bx-right-arrow-alt"></i>Blog
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/privacy/policy') }}">
                    <i class="bx bx-right-arrow-alt"></i>Privacy Policy
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/terms/condition') }}">
                    <i class="bx bx-right-arrow-alt"></i>Terms & Conditions
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/refund/policy') }}">
                    <i class="bx bx-right-arrow-alt"></i>Refund Policy
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/payment/policy') }}">
                    <i class="bx bx-right-arrow-alt"></i>Payment Policy
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/about') }}">
                    <i class="bx bx-right-arrow-alt"></i>About Us
                </a>
            </li>
        </ul>
    </li>
    @endif
</ul>
