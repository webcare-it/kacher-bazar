@extends('frontend.v-2.master')

@section('title')
    Checkout products
@endsection

@section('content-v2')
    <section class="checkout-section">
        <div class="container">
            <form action="{{ url('/customer/order/confirm') }}" method="post" class="form-group billing-address-form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout-wrapper">
                            @php
                                $sum1 = 0;
                                $qtyTotal = 0;
                            @endphp
                            @foreach ($carts as $cart)
                                <input type="hidden" name="id[]" value="{{ $cart->product_id }}">
                                <input type="hidden" name="qty[]" value="{{ $cart->qty }}">
                                <input type="hidden" name="size[]" value="{{ $cart->size ?? 'No size' }}">
                                <input type="hidden" name="color[]" value="{{ $cart->color ?? 'No color' }}">
                                <input type="hidden" id="unitprice-{{ $cart->id }}" value="{{ $cart->price / $cart->qty }}">
                                @php
                                    $sum1 += $cart->price;
                                    $qtyTotal += $cart->qty;
                                @endphp
                            @endforeach
                            <input type="hidden" name="totalCost" id="totalCost" value="{{ $sum1 }}">
                            <input type="hidden" name="totalQty" id="totalQty" value="{{ $qtyTotal }}">
                            <input type="hidden" id="deliveryChargeInput" value="0">
                            <input type="hidden" id="prevGrandTotal" value="{{ $sum1 }}">

                            <div class="billing-address-wrapper">
                                <h4 class="title">Billing / Shipping Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="order_type" value="Website" class="form-control">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name *">
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="phone" class="form-control" placeholder="Phone *">
                                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <textarea rows="4" name="address" class="form-control" placeholder="Enter Full Address"></textarea>
                                        @error('sub_district_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div style="background: lightgrey;padding: 10px;margin-bottom: 10px;">
                                            <input type="radio" id="inside_dhaka" name="area" value="60" onchange="deliveryCharge(this.value)">
                                            <label for="inside_dhaka" style="font-size: 18px;font-weight: 600;color: #000;">Inside Dhaka (60 Tk.)</label>
                                        </div>
                                        <div style="background: lightgrey;padding: 10px;">
                                            <input type="radio" id="outside_dhaka" name="area" value="120" onchange="deliveryCharge(this.value)">
                                            <label for="outside_dhaka" style="font-size: 18px;font-weight: 600;color: #000;">Outside Dhaka (120 Tk.)</label>
                                        </div>
                                        @error('area') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Summary -->
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout-items-wrapper">
                            @foreach ($carts as $cart)
                            @if($cart->product)
                                <div class="checkout-item-outer">
                                    <div class="checkout-item-left">
                                        <div class="checkout-item-image">
                                            <img src="{{ asset('product/images/' . $cart->product->image) }}" />
                                        </div>
                                        <div class="checkout-item-info">
                                            <h6 class="checkout-item-name">{{ $cart->product->name }}</h6>
                                            <p class="checkout-item-price text-muted">&#2547; {{ number_format($cart->price / $cart->qty, 2) }}</p>
                                            <span class="checkout-item-count" id="showItemqty-{{ $cart->id }}">{{ $cart->qty }} item</span><br>
                                            <span class="checkout-item-count">Size: {{ $cart->size ?? 'No size' }}</span> |
                                            <span class="checkout-item-count">Color: {{ $cart->color ?? 'No color' }}</span>

                                            <div class="checkout-product-incre-decre mt-2">
                                                <button type="button" class="qty-decrement-btn" onclick="decrementValue({{ $cart->id }});"><i class="fas fa-minus"></i></button>
                                                <input type="number" readonly id="indqty-{{ $cart->id }}" value="{{ $cart->qty }}" style="height: 35px;" min="1">
                                                <button type="button" class="qty-increment-btn" onclick="incrementValue({{ $cart->id }});"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-item-right">
                                        <a href="{{ url('/product/delete/form/cart/' . $cart->id) }}" class="delete-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @endforeach

                            <div class="sub-total-wrap">
                                <div class="sub-total-item">
                                    <strong>Sub Total</strong>
                                    <strong id="subTotal">৳ {{ $sum1 }}</strong>
                                </div>
                                <div class="sub-total-item">
                                    <strong>Delivery charge</strong>
                                    <strong id="deliveryCharge">৳ 0</strong>
                                </div>
                                <div class="sub-total-item grand-total">
                                    <strong>Grand Total</strong>
                                    <strong id="grandTotal">৳ {{ $sum1 }}</strong>
                                </div>
                            </div>

                            <div class="payment-item-outer">
                                <h6 class="payment-item-title">Select Payment Method</h6>
                                <div class="payment-items-wrap justify-content-center">
                                    <div class="payment-item-outer">
                                        <input type="radio" name="payment_type" id="cod" value="cod" checked>
                                        <label class="payment-item-outer-lable" for="cod"><strong>Cash On Delivery</strong></label>
                                    </div>
                                </div>
                            </div>

                            <div class="order-place-btn-outer">
                                <button type="submit" class="order-place-btn-inner">
                                    Place an Order <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        let cartTotal = 0; // global variable

        function deliveryCharge(cost) {
            document.getElementById('deliveryCharge').innerHTML = '৳' + cost;
            document.getElementById('deliveryChargeInput').value = cost;
            calculateGrandTotal();
        }

        function incrementValue(cartId) {
            let qtyInput = document.getElementById('indqty-' + cartId);
            let qty = parseInt(qtyInput.value);
            if (qty < 100) {
                qty += 1;
                qtyInput.value = qty;
                calculateGrandTotal();
                updateCartQty(cartId, 'increment');
            }
        }

        function decrementValue(cartId) {
            let qtyInput = document.getElementById('indqty-' + cartId);
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qty -= 1;
                qtyInput.value = qty;
                calculateGrandTotal();
                updateCartQty(cartId, 'decrement');
            }
        }

        function updateCartQty(cartId, type) {
            const url = "{{ route('cart.update', ':id') }}".replace(':id', cartId);

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.updatedQty !== undefined) {
                        // Update quantity input
                        document.getElementById('indqty-' + cartId).value = data.updatedQty;
                        document.getElementById('showItemqty-' + cartId).textContent = data.updatedQty + ' item';
                        // Update totals
                        calculateGrandTotal();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('[id^="unitprice-"]').forEach(input => {
                const cartId = input.id.split('-')[1];
                const qty = parseInt(document.getElementById('indqty-' + cartId).value);
                const price = parseFloat(input.value);
                total += qty * price;
            });

            const deliveryCharge = parseInt(document.getElementById('deliveryChargeInput').value) || 0;
            const grandTotal = total + deliveryCharge;

            // update global cartTotal
            cartTotal = grandTotal;

            document.getElementById("subTotal").textContent = '৳' + total.toFixed(2);
            document.getElementById("grandTotal").textContent = '৳' + grandTotal.toFixed(2);
            document.getElementById("totalCost").value = grandTotal;
            document.getElementById("prevGrandTotal").value = grandTotal;
        }

        window.addEventListener('load', () => {
            calculateGrandTotal();

            // Fire GTM event when checkout begins
            dataLayer.push({ ecommerce: null }); // clear previous ecommerce object
            dataLayer.push({
                event: "begin_checkout",
                ecommerce: {
                    currency: "BDT",
                    value: cartTotal,
                    items: [
                            @foreach ($carts as $cart)
                        {
                            item_name     : "{{ $cart->product->name }}",
                            item_id       : "{{ $cart->product->id }}",
                            price         : "{{ number_format($cart->price / $cart->qty, 2) }}",
                            item_brand    : "Unknown",
                            item_category : "Unknown",
                            item_variant  : "{{ $cart->size ?? '' }}{{ $cart->color ? ',' . $cart->color : '' }}",
                            item_list_name: "",
                            item_list_id  : "",
                            index         : 0,
                            quantity      : "{{ $cart->qty }}"
                        },
                        @endforeach
                    ]
                }
            });
        });
    </script>
@endpush
