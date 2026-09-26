@extends('admin.master')

@push('style')
    <style>
        .checkout-wrapper {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .billing-address-form input.form-control,
        select.form-control {
            height: 60px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .billing-address-wrapper .title {
            font-size: 25px;
            font-weight: 500;
            margin-bottom: 25px;
            color: #111;
        }

        .custome-checkbox {
            margin-bottom: 20px;
        }

        .checkout-input-number:focus {
            box-shadow: none;
        }

        .order-place-btn-outer {
            text-align: center;
            margin-top: 20px;
        }

        .order-place-btn-inner {
            display: block;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            padding: 12px 0px;
            border-radius: 4px;
            color: #fff;
            border: 1px solid #ee1c47;
            background-color: #ee1c47;
            cursor: pointer;
            -webkit-transition: all 300ms linear 0s;
            transition: all 300ms linear 0s;
            letter-spacing: 0.5px;
        }

        .order-place-btn-inner:hover {
            background: transparent;
            color: #ee1c47;

        }

        .checkout-item-outer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .checkout-item-left {
            display: flex;
        }

        .checkout-item-image {
            margin-right: 10px;
        }

        .checkout-item-image img {
            width: 90px;
            height: 90px;
        }

        .checkout-item-name {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .checkout-item-price {
            font-size: 16px;
            font-weight: 800;
            color: #ee1c47;
            margin-bottom: 0;
        }

        .checkout-item-count {
            font-size: 15px;
            font-weight: 500;
        }

        .checkout-item-right .delete-btn {
            background: #ee1c47;
            color: #fff;
            border: none;
            padding: 5px 8px;
            border-radius: 5px;
        }

        .sub-total-wrap .sub-total-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .sub-total-item.grand-total {
            border-top: 1px solid #EEEEEE;
            padding-top: 10px;
            margin-bottom: 25px;
        }

        .checkout-items-wrapper {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 20px;
            border-radius: 10px;
        }

        .checkout-product-incre-decre {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .qty-increment-btn {
            background: transparent;
            border: 1px solid #ee1c47;
            font-size: 14px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            line-height: 22px;
            color: #ee1c47;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .qty-decrement-btn {
            background: transparent;
            border: 1px solid #ee1c47;
            font-size: 14px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            line-height: 22px;
            color: #ee1c47;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .qty-decrement-btn:focus,
        .qty-increment-btn:focus {
            outline: none
        }

        .qty-decrement-btn i,
        .qty-increment-btn i {
            font-size: 16px;
            font-weight: 700;
        }

        .qty-increment-btn:hover,
        .qty-decrement-btn:hover {
            background: #ee1c47;
            color: #fff;
        }

        .checkout-item-left .checkout-product-incre-decre input {
            background: #fff;
            border: 1px solid #ee1d48 !important;
            font-size: 18px;
            font-weight: 700;
            color: #ee1d48;
            border-radius: 5px;
            text-align: center;
            max-width: 75px;
            margin: 0 5px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <section class="checkout-section">
                <form action="{{ url('/customer/order/confirm/manual') }}" method="post" class="form-group billing-address-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout-wrapper">
                                @php
                                    $sum1 = 0;
                                    $qtyTotal = 0;
                                @endphp
                                @foreach ($products as $product)
                                    <input type="hidden" name="id[]" id="id" value="{{ $product->id }}"
                                        class="form-control">
                                    <input type="hidden" name="qty[]" id="qty" value="{{ $totalQty = 1 }}"
                                        class="form-control">
                                    <input type="hidden" name="total[]" id="totalProductCost"
                                        value="@if ($product->discount_price == null) {{ $total1 = $product->regular_price }}
                                @else
                                {{ $total1 = $product->discount_price }} @endif"
                                        class="form-control">
                                    @php
                                        $sum1 += $total1;
                                        $qtyTotal += $totalQty;
                                    @endphp
                                @endforeach
                                <input type="hidden" name="totalCost" id="totalCost" value="{{ $sum1 }}" />
                                <input type="hidden" name="totalQty" id="totalQty" value="{{ $qtyTotal }}" />
                                <span id="charge" style="display: none;"></span>
                                <span id="total" style="display: none;"></span>
                                <div class="billing-address-wrapper">
                                    <h4 class="title">Billing / Shipping Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="order_type" value="Manual" class="form-control">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Enter Full Name *">
                                            @if ($errors->has('name'))
                                                <div class="text-danger">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="phone" class="form-control" placeholder="Phone *">
                                            @if ($errors->has('phone'))
                                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <textarea rows="4" name="address" class="form-control" id="address" placeholder="Enter Full Address"></textarea>
                                            <!-- <input type="text" name="address" id="address" class="form-control" placeholder="Enter Full Address"> -->
                                            @if ($errors->has('sub_district_id'))
                                                <div class="text-danger">{{ $errors->first('sub_district_id') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div style="background: lightgrey;padding: 10px;margin-bottom: 10px;">
                                                <input type="radio" id="inside_dhaka" name="area" value="60"
                                                    onchange="deliveryCharge(this.value)">
                                                <label for="inside_dhaka"
                                                    style="font-size: 18px;font-weight: 600;color: #000;">Inside Dhaka (60
                                                    Tk.)</label>
                                            </div>
                                            <div style="background: lightgrey;padding: 10px;">
                                                <input type="radio" id="outside_dhaka" name="area" value="120"
                                                    onchange="deliveryCharge(this.value)">
                                                <label for="outside_dhaka"
                                                    style="font-size: 18px;font-weight: 600;color: #000;">Outside Dhaka (120
                                                    Tk.)</label>
                                            </div>
                                            @if ($errors->has('area'))
                                                <div class="text-danger">{{ $errors->first('area') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout-items-wrapper">
                                @foreach ($products as $key => $product)
                                    <div class="checkout-item-outer">
                                        <div class="checkout-item-left">
                                            <div class="checkout-item-image">
                                                <img src="{{ asset('product/images/' . $product->image) }}" />
                                            </div>
                                            <div class="checkout-item-info">
                                                <h6 class="checkout-item-name">
                                                    {{ $product->name }}
                                                </h6>
                                                <p class="checkout-item-price">
                                                    @if ($product->discount_price == null)
                                                        {{ $product->regular_price }} Tk.
                                                    @else
                                                        {{ $product->discount_price }} Tk.
                                                    @endif
                                                </p>
                                                <span class="checkout-item-count">
                                                    {{-- {{ $product->qty }} item --}}
                                                    1 item
                                                </span><br />
                                                <span class="checkout-item-count">
                                                    {{-- Size: {{ $product->size ? $product->size : 'No size' }} --}}
                                                    @php
                                                        $hasImageSizes = false;
                                                        $imageSizes = [];
                                                        if(count($product->productImages) > 0) {
                                                            foreach($product->productImages as $img) {
                                                                if($img->size) {
                                                                    $hasImageSizes = true;
                                                                    $imageSizes[] = $img;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if($hasImageSizes)
                                                        <strong>Select Size:</strong><br>
                                                        <select class="form-control form-control-sm size-select" data-product-id="{{ $product->id }}" data-key="{{ $key }}" style="height: 40px; margin-bottom: 10px;">
                                                            <option value="">Select Size</option>
                                                            @foreach ($imageSizes as $img)
                                                                @php
                                                                    $isSelected = false;
                                                                    if (isset($selectedSize) && $selectedSize == $img->size) {
                                                                        $isSelected = true;
                                                                    } elseif (isset($selectedSizes) && isset($selectedSizes[$product->id]) && $selectedSizes[$product->id] == $img->size) {
                                                                        $isSelected = true;
                                                                    }
                                                                @endphp
                                                                <option value="{{ $img->size }}" data-price="{{ $img->price }}" {{ $isSelected ? 'selected' : '' }}>
                                                                    {{ $img->size }} - {{ $img->price }} Tk.
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="size[]" id="selected-size-{{ $product->id }}" value="{{ $selectedSize ?? '' }}">
                                                    @elseif (count($product->sizes) > 0)
                                                        <strong>Select Size:</strong><br>
                                                        <select class="form-control form-control-sm size-select" data-product-id="{{ $product->id }}" data-key="{{ $key }}" style="height: 40px; margin-bottom: 10px;">
                                                            <option value="">Select Size</option>
                                                            @foreach ($product->sizes as $size)
                                                                @if ($size->size != null)
                                                                    @php
                                                                        $isSelected = false;
                                                                        if (isset($selectedSize) && $selectedSize == $size->size) {
                                                                            $isSelected = true;
                                                                        } elseif (isset($selectedSizes) && isset($selectedSizes[$product->id]) && $selectedSizes[$product->id] == $size->size) {
                                                                            $isSelected = true;
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $size->size }}" data-price="@if ($product->discount_price == null){{ $product->regular_price }}@else{{ $product->discount_price }}@endif" {{ $isSelected ? 'selected' : '' }}>
                                                                        {{ $size->size }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="size[]" id="selected-size-{{ $product->id }}" value="{{ $selectedSize ?? '' }}">
                                                    @else
                                                        <input type="hidden" name="size[]" value="No size">
                                                    @endif
                                                </span>
                                                    {{-- <span class="text-danger" style="font-weight: 600">|</span> --}}
                                                    <span class="checkout-item-count">
                                                        {{-- Color: {{ $product->color ? $product->color : 'No color' }} --}}
                                                        <div class="product-color-options">
                                                            @if (count($product->colors) > 0)
                                                                <strong>Select Color:</strong><br>
                                                                @foreach ($product->colors as $color)
                                                                    @if ($color->color != null)
                                                                        @php
                                                                            $isColorSelected = false;
                                                                            if (isset($selectedColor) && $selectedColor == $color->color) {
                                                                                $isColorSelected = true;
                                                                            } elseif (isset($selectedColors) && isset($selectedColors[$product->id]) && $selectedColors[$product->id] == $color->color) {
                                                                                $isColorSelected = true;
                                                                            }
                                                                        @endphp
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input color-radio" type="radio"
                                                                                name="color[{{ $key }}]" id="color-{{ $key }}-{{ $color->id }}"
                                                                                value="{{ $color->color }}" data-product-id="{{ $product->id }}" {{ $isColorSelected ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="color-{{ $key }}-{{ $color->id }}">{{ $color->color }}</label>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                <input type="hidden" name="color[]" id="selected-color-{{ $product->id }}" value="{{ $selectedColor ?? '' }}">
                                                            @else
                                                                <input type="hidden" name="color[]" value="No color" id="selected-color-{{ $product->id }}">
                                                            @endif
                                                        </div>
                                                        <div class="checkout-product-incre-decre">
                                                            <button type="button" title="Decrement"
                                                                onclick="decrementValue({{ $product->id }}); subTotalCost({{ $product->id }});"
                                                                class="qty-decrement-btn">
                                                                <i class="bx bx-minus"></i>
                                                            </button>
                                                            <input type="number" readonly name="indqty[]"
                                                                placeholder="Qty" min="1"
                                                                id="indqty-{{ $product->id }}" style="height: 35px;"
                                                                value="1">
                                                            <button type="button" title="Increment"
                                                                onclick="incrementValue({{ $product->id }}); subTotalCost({{ $product->id }});"
                                                                class="qty-increment-btn">
                                                                <i class="bx bx-plus"></i>
                                                            </button>
                                                            <input type="hidden"
                                                                value="@if ($product->discount_price == null) {{ $product->regular_price * 1 }}
                                                    @else
                                                    {{ $product->discount_price * 1 }} @endif"
                                                                id="indprice-{{ $product->id }}" name="indprice[]">
                                                            <input type="hidden"
                                                                value="@if ($product->discount_price == null) {{ $product->regular_price * 1 }}
                                                    @else
                                                    {{ $product->discount_price * 1 }} @endif"
                                                                id="indprice1-{{ $product->id }}" name="indprice1[]">
                                                            <span id="showprice-{{ $product->id }}">
                                                                @if ($product->discount_price == null)
                                                                    {{ $product->regular_price * 1 }}৳
                                                                @else
                                                                    {{ $product->discount_price * 1 }}৳
                                                                @endif
                                                            </span>
                                                            <input type="hidden" id="totalindprice-{{ $product->id }}">
                                                            <input type="hidden" id="updatedCost" name="updatedCost[]">
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="sub-total-wrap">
                                    <div class="sub-total-item">
                                        <strong>Sub Total</strong>
                                        <strong id="subTotal">৳ {{ $sum1 }}</strong>
                                    </div>
                                    <div class="sub-total-item">
                                        <strong>Delivery charge</strong>
                                        <strong id="deliveryCharge">৳ 0</strong>
                                        <input type="hidden" id="deliveryChargeInput">
                                    </div>
                                    <div class="sub-total-item grand-total">
                                        <strong>Grand Total</strong>
                                        <strong id="grandTotal">৳ 0</strong>
                                        <input type="hidden" id="prevGrandTotal">
                                    </div>
                                </div>
                                <div class="payment-item-outer">
                                    <h6 class="payment-item-title">
                                        Select Payment Method
                                    </h6>
                                    <div class="payment-items-wrap justify-content-center">
                                        <div class="payment-item-outer">
                                            <input type="radio" name="payment_type" id="cod" value="cod"
                                                checked="">
                                            <label class="payment-item-outer-lable" for="cod">
                                                <strong>Cash On Delivery</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-place-btn-outer">
                                    <button type="submit" class="order-place-btn-inner">
                                        Place an Order
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let total = document.getElementById('total').innerHTML;
        let totalCost = document.getElementById('totalCost').value;

        // Initialize hidden inputs on page load with pre-selected values
        document.addEventListener('DOMContentLoaded', function() {
            // Set size hidden inputs and prices
            document.querySelectorAll('.size-select').forEach(function(select) {
                if (select.value) {
                    const productId = select.dataset.productId;
                    const hiddenInput = document.getElementById('selected-size-' + productId);
                    if (hiddenInput) {
                        hiddenInput.value = select.value;
                    }

                    // Update price based on selected size
                    const selectedOption = select.options[select.selectedIndex];
                    const price = selectedOption.dataset.price;
                    if (price) {
                        updateProductPrice(productId, price);
                    }
                }
            });

            // Set color hidden inputs
            document.querySelectorAll('.color-radio:checked').forEach(function(radio) {
                const productId = radio.dataset.productId;
                const hiddenInput = document.getElementById('selected-color-' + productId);
                if (hiddenInput) {
                    hiddenInput.value = radio.value;
                }
            });

            // Calculate initial grand total
            calculateGrandTotal();
        });

        // Function to update product price
        function updateProductPrice(productId, price) {
            const priceInput = document.getElementById('indprice-' + productId);
            const priceInput1 = document.getElementById('indprice1-' + productId);
            const showPrice = document.getElementById('showprice-' + productId);
            const qty = document.getElementById('indqty-' + productId).value;

            if (priceInput && priceInput1 && showPrice) {
                priceInput.value = price;
                priceInput1.value = price * qty;
                showPrice.innerHTML = (price * qty) + '৳';
            }
        }

        // Size selection handler
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('size-select')) {
                const productId = e.target.dataset.productId;
                const selectedSize = e.target.value;
                const selectedOption = e.target.options[e.target.selectedIndex];
                const price = selectedOption.dataset.price;

                // Update hidden input for size
                document.getElementById('selected-size-' + productId).value = selectedSize;

                // Update price based on selected size
                if (price) {
                    updateProductPrice(productId, price);
                }

                // Recalculate grand total
                calculateGrandTotal();
            }
        });

        // Color selection handler
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('color-radio')) {
                const productId = e.target.dataset.productId;
                const selectedColor = e.target.value;

                // Update hidden input for color
                document.getElementById('selected-color-' + productId).value = selectedColor;
            }
        });

        function deliveryCharge(cost) {
            let charge = document.getElementById('deliveryCharge').innerHTML = cost;
            let deliveryChargeInput = document.getElementById('deliveryChargeInput').value = cost;
            let totalAmount = document.getElementById('grandTotal').innerHTML = parseInt(totalCost) + parseInt(cost);
            let totalInputAmount = document.getElementById('totalCost').value = parseInt(totalCost) + parseInt(cost);
        }

        function districtName(districtId) {
            axios.get('/district-wise-sub_district/' + districtId)
                .then(response => {
                    console.log(response.data)
                    opt = '';
                    opt += "<option value=''>Select a SubDistrict</option>";
                    for (let i = 0; i <= response.data.length - 1; i++) {
                        opt += "<option value='" + response.data[i].id + "'>" + response.data[i].name + "</option>";
                    }

                    document.getElementById('sub_district').innerHTML = opt;
                }).catch(error => {
                    console.log(error);
                })
        }

        //Payment type change
        function paymentTypeChange(e) {
            console.log(e.value);
        }

        function incrementValue(productId) {
            var value = parseInt(document.getElementById('indqty-' + productId).value, 10);
            value = isNaN(value) ? 0 : value;
            if (value < 10) {
                value++;
                document.getElementById('indqty-' + productId).value = value;
            }
        }

        function decrementValue(productId) {
            var value = parseInt(document.getElementById('indqty-' + productId).value, 10);
            value = isNaN(value) ? 0 : value;
            if (value > 1) {
                value--;
                document.getElementById('indqty-' + productId).value = value;
            }
        }

        function calculateGrandTotal() {
            var updatedCostInputs = document.getElementsByName("indprice1[]");
            var grandTotal = 0;

            for (var i = 0; i < updatedCostInputs.length; i++) {
                grandTotal += parseFloat(updatedCostInputs[i].value);
            }
            let charge = parseInt(document.getElementById('deliveryChargeInput').value);
            if (isNaN(charge)) {
                charge = 0;
            }
            var totalWithDelivery = grandTotal + charge;
            //document.getElementById("grandTotal").textContent = grandTotal.toFixed(2) + "৳";
            document.getElementById("grandTotal").textContent = totalWithDelivery.toFixed(2) + "৳";
            document.getElementById("subTotal").textContent = grandTotal.toFixed(2) + "৳";
        }

        function subTotalCost(productId) {
            var price = parseFloat(document.getElementById('indprice-' + productId).value);
            var qty = parseInt(document.getElementById('indqty-' + productId).value);
            var totalIndPrice = qty * price;
            console.log(totalIndPrice);
            console.log("Total Price");
            document.getElementById('showprice-' + productId).innerHTML = totalIndPrice + '৳';
            document.getElementById('indprice1-' + productId).value = totalIndPrice;
            calculateGrandTotal();
        }
    </script>
@endpush
