@extends('frontend.v-2.master')

@section('title')
    Checkout products
@endsection

@section('content-v2')
    <div class="thank-you-wrapper" style="position: relative;">
        <div class="js-container" style="height: 100vh;"></div>
        <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);text-align: center;max-width: 750px;">
            <div class="checkmark-circle">
                <div class="background"></div>
                <div class="checkmark draw"></div>
            </div>
            <h3 class="py-3">অর্ডার নম্বর : {{$order_details->orderId}}</h3>
            {{-- <h3 class="py-3">Total Price : {{$order_details->price}}</h3> --}}
            <p class="thank-you-message">
                আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে ।আমাদের কল সেন্টার থেকে ফোন করে আপনার অর্ডারটি কনফার্ম করা হবে
            </p>
            <a href="{{ url('/') }}" class="thank-you-btn-inner">Go To Home</a>
        </div>
    </div>
    <div style="display: none">
      <input type="text" id="transaction_id" value="{{$order_details->orderId}}">
      <input type="text" id="value" value="{{$order_details->price}}">
      <input type="text" id="shipping" value="{{$order_details->area}}">
      <input type="text" id="customer_name" value="{{$order_details->name}}">
      <input type="text" id="customer_phone" value="{{$order_details->phone}}">
      <input type="text" id="customer_email" value="{{$order_details->email ?? ''}}">
      <input type="text" id="customer_address" value="{{$order_details->address}}">
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        const Confettiful = function(el) {
          this.el = el;
          this.containerEl = null;

          this.confettiFrequency = 3;
          this.confettiColors = ['#EF2964', '#00C09D', '#2D87B0', '#48485E','#EFFF1D'];
          this.confettiAnimations = ['slow', 'medium', 'fast'];

          this._setupElements();
          this._renderConfetti();
        };

        Confettiful.prototype._setupElements = function() {
          const containerEl = document.createElement('div');
          const elPosition = this.el.style.position;

          if (elPosition !== 'relative' || elPosition !== 'absolute') {
            this.el.style.position = 'relative';
          }

          containerEl.classList.add('confetti-container');

          this.el.appendChild(containerEl);

          this.containerEl = containerEl;
        };

        Confettiful.prototype._renderConfetti = function() {
          this.confettiInterval = setInterval(() => {
            const confettiEl = document.createElement('div');
            const confettiSize = (Math.floor(Math.random() * 3) + 7) + 'px';
            const confettiBackground = this.confettiColors[Math.floor(Math.random() * this.confettiColors.length)];
            const confettiLeft = (Math.floor(Math.random() * this.el.offsetWidth)) + 'px';
            const confettiAnimation = this.confettiAnimations[Math.floor(Math.random() * this.confettiAnimations.length)];

            confettiEl.classList.add('confetti', 'confetti--animation-' + confettiAnimation);
            confettiEl.style.left = confettiLeft;
            confettiEl.style.width = confettiSize;
            confettiEl.style.height = confettiSize;
            confettiEl.style.backgroundColor = confettiBackground;

            confettiEl.removeTimeout = setTimeout(function() {
              confettiEl.parentNode.removeChild(confettiEl);
            }, 3000);

            this.containerEl.appendChild(confettiEl);
          }, 25);
        };

        window.confettiful = new Confettiful(document.querySelector('.js-container'));
    </script>

        {{-- Data Layer... --}}
<script type = "text/javascript">
  window.addEventListener('load', function() {
    var transaction_id = document.getElementById('transaction_id').value;
    var value = document.getElementById('value').value;
    var shipping = document.getElementById('shipping').value;
    var customer_name = document.getElementById('customer_name').value;
    var customer_phone = document.getElementById('customer_phone').value;
    var customer_email = document.getElementById('customer_email').value;
    var customer_address = document.getElementById('customer_address').value;

    var nameParts = customer_name.split(' ');
    var first_name = nameParts[0] || '';
    var last_name = nameParts.slice(1).join(' ') || '';

    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event    : "purchase",
        ecommerce: {
            transaction_id: transaction_id,
            affiliation   : "Droploo",
            value         : value,
            tax           : 0,
            shipping      : shipping,
            currency      : "BDT",
            coupon        : "null",
            items         : [@foreach ($order_details->orderDetails as $product){
                item_name    : "{{$product->product->name}}",
                item_id      : "{{$product->product->id}}",
                price        : "{{$product->product->regular_price}}",
                item_brand   : "Unknown",
                item_category: "Unknown",
                item_variant : "",
                quantity     : {{$product->qty}}
            },@endforeach],
            user_data     : {
                first_name   : first_name,
                last_name    : last_name,
                phone_number : customer_phone,
                email        : customer_email,
                address      : {
                    first_name : first_name,
                    last_name  : last_name,
                    street     : customer_address
                }
            }
        }
    });
  });
</script>
@endpush
