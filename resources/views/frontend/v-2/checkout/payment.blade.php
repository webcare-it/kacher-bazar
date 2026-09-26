@extends('frontend.master')

@section('title')
    Payment
@endsection

@section('content')
    <section class="product-page-banner-section">
        <div class="banner-bg-image">
            <img src="{{ asset('/frontend/') }}/assets/images/banner.png">
        </div>
        <div class="banner-content">
            <h3 class="banner-content-title" style="color: #02075d; font-weight: 700">
                Customer Payment
            </h3>
        </div>
    </section>
    <form action="{{ route('customer.payment') }}" method="post" enctype="multipart/form-data">
        @csrf
        <section class="billing-shipping-address-section">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="shopping-cart-section">
                    <div class="section-title">
                        Payment Information
                    </div>
                    <div class="shopping-cart-section-body">
                        <table class="table table-bordered shopping-product-list">
                            <thead>
                                <tr>
                                    <td class="text-center td-image">Image</td>
                                    <td class="text-center td-product">Product Name</td>
                                    <td class="text-center td-qty">Quantity</td>
                                    <td class="text-center td-price">Price</td>
                                    <td class="text-center td-total">Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach ($products as $product)
                                    <input type="hidden" name="vendor_id[]" value="{{ $product->product->vendor_id ?? 0 }}" />
                                    <input type="hidden" name="regular_price[]" value="{{ $product->product->regular_price ?? '' }}" />
                                    <input type="hidden" name="order_product_id[]" value="{{ $product->product_id ?? '' }}" />
                                    <input type="hidden" name="product_id" value="{{ $product->product_id ?? '' }}" />
                                    <input type="hidden" name="order_qty[]" min="1" value="{{ $product->qty ?? '' }}" />
                                    <input type="hidden" name="qty" min="1" value="{{ $product->qty ?? '' }}" />
                                    <input type="hidden" name="price" value="{{ $product->price ?? '' }}" />
                                    <tr>
                                        <td class="text-center td-image">
                                            <a href="#">
                                                <img src="{{ asset('/product/images/' . $product->product->image ?? '#') }}" alt="image" class="img-thumbnail">
                                            </a>
                                        </td>
                                        <td class="text-center td-product">
                                            <a href="#">
                                                {{ $product->product->name ?? 'Name not found' }}
                                            </a>
                                        </td>
                                        <td class="text-center td-qty">
                                            {{ $product->qty ?? 'Qty' }}
                                        </td>
                                        <td class="text-center td-price">৳{{ $product->price }}</td>
                                        <td class="text-center td-total">৳{{ $subTotal = $product->price * $product->qty }}</td>
                                    </tr>
                                    @php
                                        $sum += $subTotal
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-bordered total-amount">
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <strong>Sub-Total:</strong>
                                    </td>
                                    <td class="text-right">৳{{ $sum }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <strong>Handling/Packing Fee:</strong>
                                    </td>
                                    <td class="text-right">৳00.00</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <strong>Flat Shipping Rate:</strong>
                                    </td>
                                    <td class="text-right">৳00.00</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right">
                                        <strong>Total:</strong>
                                    </td>
                                     <td class="text-right total-price">
                                         <strong>৳{{ $sum }}</strong>
                                     </td>
                                     <input type="hidden" name="total_pay" value="{{ $sum }}" />
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="shopping-payment-method-section">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item payment-method-item" role="presentation">
                            <button class="nav-link active" id="pills-bkash-tab" data-bs-toggle="pill" data-bs-target="#pills-bkash" type="button" role="tab" aria-controls="pills-bkash" aria-selected="true">
                                <img src="{{ asset('/frontend/') }}/assets/images/bkash.png">
                                <h4 class="item-name">
                                    Bkash
                                </h4>
                            </button>
                        </li>
                        <li class="nav-item payment-method-item" role="presentation">
                            <button class="nav-link" id="pills-nogad-tab" data-bs-toggle="pill" data-bs-target="#pills-nogad" type="button" role="tab" aria-controls="pills-nogad" aria-selected="false">
                                <img src="{{ asset('/frontend/') }}/assets/images/nagad.png" alt="">
                                <h4 class="item-name">
                                    Nogad
                                </h4>
                            </button>
                        </li>
                        <li class="nav-item payment-method-item" role="presentation">
                            <button class="nav-link" id="pills-rocket-tab" data-bs-toggle="pill" data-bs-target="#pills-rocket" type="button" role="tab" aria-controls="pills-rocket" aria-selected="false">
                                <img src="{{ asset('/frontend/') }}/assets/images/rocket.png" alt="">
                                <h4 class="item-name">
                                    Rocket
                                </h4>
                            </button>
                        </li>
                        <li class="nav-item payment-method-item" role="presentation">
                            <button class="nav-link" id="pills-cashon-tab" data-bs-toggle="pill" data-bs-target="#pills-cashon" type="button" role="tab" aria-controls="pills-cashon" aria-selected="false">
                                <img src="{{ asset('/frontend/') }}/assets/images/cash-on.png" alt="">
                                <h4 class="item-name">
                                    Cash On Delivery
                                </h4>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content col-md-8 m-auto" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-bkash" role="tabpanel" aria-labelledby="pills-bkash-tab">

                            <h4 class="title">
                                <input type="radio" name="bkash" value="bkash">
                                Bkash Instructions
                            </h4>
                            <p><b>Please Bkash the total amount to the following Bkash account.</b></p>
                            <div class="well well-sm">
                                <p>bKash Details: A/C- 0123456789<br>
                                    *How to make payment?<br>
                                    01. Go to bKash Menu by dialing *247#<br>
                                    02. Choose 'Payment'<br>
                                    03. Enter the business wallet number 0123456789<br>
                                    04. Enter the amount you want to pay<br>
                                    05. Enter a reference against your payment<br>
                                    06. Now enter your PIN to confirm<br>
                                    07. Done! You will get a confirmation SMS</p>
                                    <p>Your order will not ship until we receive payment.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-nogad" role="tabpanel" aria-labelledby="pills-nogad-tab">
                            <h4 class="title">
                                <input type="radio" name="nogad" value="nogad">
                                Nogad Instructions
                            </h4>
                            <p><b>Please Nogad the total amount to the following Nogad account.</b></p>
                            <div class="well well-sm">
                                <p>Nogad Details: A/C- 0123456789<br>
                                    *How to make payment?<br>
                                    01. Go to nogad Menu by dialing *167#<br>
                                    02. Choose 'Payment'<br>
                                    03. Enter the business wallet number 0123456789<br>
                                    04. Enter the amount you want to pay<br>
                                    05. Enter a reference against your payment<br>
                                    06. Now enter your PIN to confirm<br>
                                    07. Done! You will get a confirmation SMS</p>
                                    <p>Your order will not ship until we receive payment.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-rocket" role="tabpanel" aria-labelledby="pills-rocket-tab">
                            <h4 class="title">
                                <input type="radio" name="rocket" value="rocket">
                                Rocket Instructions
                            </h4>
                            <p><b>Please Rocket the total amount to the following Rocket account.</b></p>
                            <div class="well well-sm">
                                <p>Rocket Details: A/C- 0123456789<br>
                                    *How to make payment?<br>
                                    01. Go to rocket Menu by dialing *322#<br>
                                    02. Choose 'Payment'<br>
                                    03. Enter the business wallet number 0123456789<br>
                                    04. Enter the amount you want to pay<br>
                                    05. Enter a reference against your payment<br>
                                    06. Now enter your PIN to confirm<br>
                                    07. Done! You will get a confirmation SMS</p>
                                    <p>Your order will not ship until we receive payment.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-cashon" role="tabpanel" aria-labelledby="pills-cashon-tab">
                            <h4 class="title">
                                <input type="radio" name="cod" id="cod" value="cash on delivery" onclick="hideTransactionField(this.value)">
                                Cash On Delivery
                            </h4>
                            <div class="confirm-section">
                                 <div class="section-body">
                                    <p>You can pay in cash to our courier when you receive the goods at your doorstep.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="buttons confirm-buttons col-md-8 m-auto">
                    <div class="confirm-section">
                        <div class="title confirm-section-title">Confirm Your Order</div>
                         <div class="section-body">
                            <div class="section-transaction-id">
                               <input type="text" name="transaction_id" id="transaction_id" placeholder="Enter Your Transaction Id">
                            </div>
                             <div class="checkbox">
                                <label>
                                    <input type="checkbox" required>I have read and agree to the
                                     <a href="{{ url('/privacy-policy') }}" class="agree"><b>Privacy Policy</b>
                                     </a>
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" required>I have read and agree to the
                                     <a href="{{ url('/term-conditions') }}" class="agree"><b>Terms Conditions</b>
                                    </a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="submit" id="quick-checkout-button-confirm" class="btn btn-primary">
                            <span>Confirm Order</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('script')
    <script>
        function hideTransactionField(e){
            //console.log(e)
            if( e == 'cash on delivery'){
                $('#transaction_id').hide();
            }
            else{
                $('#transaction_id').show();
            }
        }
    </script>
@endpush
