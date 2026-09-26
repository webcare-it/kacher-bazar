@extends('frontend.v-2.master')

@push('style')
    {{-- <!-- Flowbite -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"
      rel="stylesheet"
    /> --}}
    <!-- Fontawesome -->
    <script
      src="https://kit.fontawesome.com/942922f9a6.js"
      crossorigin="anonymous"
    ></script>
    <!-- Slick slider -->
    <link
      rel="stylesheet"
      type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    {{-- <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                variableproduct: '#4DBD35',
              }
            },
          },
        };
      </script> --}}
@endpush

@section('title')
    Product Details
@endsection

@section('content-v2')
<div class="product-details-section">
    <div class="container">
        <div class="row">
            <!-- Product Images Column -->
            <div class="col-lg-8 col-md-12">
                <div class="product-details-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                        <div id="carousel-product" class=" mx-auto">
                            <!-- Carousel Wrapper -->
                            <div id="slide" class="position-relative">
                                @foreach ($details->productImages as $image)
                                    <div class="mySlides">
                                        <img src="{{ asset('galleryImage/' . $image->gallery_image) }}" class="img-fluid">
                                    </div>
                                @endforeach

                                {{-- <!-- Slider Navigation -->
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="d-flex align-items-center justify-content-between">
                                       <div>
                                        <button class="prev bg-dark text-white rounded-start p-2 md-p-3 lg-p-4" onclick="plusSlides(-1)">&#10094;</button>
                                       </div>
                                      <div>
                                        <button class="next bg-dark text-white rounded-end p-2 md-p-3 lg-p-4" onclick="plusSlides(1)">&#10095;</button>
                                      </div>
                                    </div>
                                </div> --}}
                            </div>


                            <!-- Thumbnail Images -->
                            <div class="d-flex align-items-center justify-content-center mt-3">
                                @foreach ($details->productImages as $image)
                                    <div class="column">
                                        <img class="thumbnail cursor w-50" src="{{ asset('galleryImage/' . $image->gallery_image) }}" onclick="currentSlide({{ $loop->index + 1 }})" alt="gallery_image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                        <!-- Product Details Column -->
                        <div class="col-lg-5 col-md-5">
                            <div class="product-details-content">
                                <h3 class="product-name mb-3">
                                    {{ $details->name ?? 'Product Name' }}
                                </h3>

                                <!-- Price Section -->
                                <div class="product-price mb-3">
                                    <span id="price" style="font-size: 20px">
                                        @if ($details->discount_price != null)
                                            {{$details->discount_price}}
                                        @else
                                            {{$details->regular_price}}
                                        @endif
                                    </span> TK.
                                </div>

                                <!-- Product Description -->
                                <p class="short-description mb-4" style="color: #666; line-height: 1.6;">
                                    {{ $details->short_description ?? 'No description available' }}
                                </p>

                                <!-- Color Selection -->
                                @if($details->productImages && $details->productImages->count() > 0)
                                    @php
                                        $colors = $details->productImages->pluck('color')->filter()->unique()->values();
                                    @endphp
                                    @if($colors->count() > 0)
                                    <div class="mb-4">
                                        <label class="d-block mb-2" style="font-weight: 600;">Select Color:</label>
                                        <div class="product-details-select-items-wrap d-flex gap-2 flex-wrap">
                                            @foreach ($colors as $color)
                                            <div class="product-details-select-item-outer">
                                                <input type="radio"
                                                       name="color"
                                                       id="color_{{ $loop->index }}"
                                                       value="{{ $color }}"
                                                       class="category-item-radio color-radio"
                                                       onchange="onColorChange('{{ $color }}')"
                                                       @if($loop->first) checked @endif>
                                                <label for="color_{{ $loop->index }}" class="category-item-label" style="cursor: pointer;
        /* padding: 0 16px; */
        border: 2px solid #ddd;
        border-radius: 4px;
        display: inline-block;
        transition: all 0.3s;
        font-size: 14px;">{{ $color }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="inputcolor" id="inputcolor" value="{{ $colors->first() ?? '' }}">
                                    </div>
                                    @endif
                                @endif

                                <!-- Size Selection -->
                                @if($details->productImages && $details->productImages->where('size', '!=', null)->count() > 0)
                                <div class="mb-4">
                                    <label class="d-block mb-2" style="font-weight: 600;">Select Size:</label>
                                    <div class="product-details-select-items-wrap d-flex gap-2 flex-wrap sizeButtonGroups">
                                        @foreach ($details->productImages as $image)
                                           @if ($image->size != null)
                                           <div class="product-details-select-item-outer">
                                               <input type="radio"
                                                      name="size"
                                                      id="size-{{$loop->index}}"
                                                      value="{{$image->size}}"
                                                      data-price="{{$image->price ?? $details->discount_price ?? $details->regular_price}}"
                                                      data-color="{{$image->color ?? ''}}"
                                                      data-size="{{$image->size}}"
                                                      class="category-item-radio size-radio"
                                                      onchange="onSizeChange(this)">
                                               <label for="size-{{$loop->index}}" style="font-size: 13px;" class="category-item-label">{{$image->size}}</label>
                                           </div>
                                           @endif
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="inputsize" id="inputsize" value="{{ $details->productImages->first()->size ?? '' }}">
                                </div>
                                @endif
                                <!-- Add to Cart Form -->
                                <form action="{{ url('/add/to/cart/variable-details/page/' . $details->id) }}"
                                      method="POST"
                                      id="addToCartForm"
                                      onsubmit="onSubmitForm(event)">
                                    @csrf
                                    <input type="hidden" name="inputcolor" id="cart_inputcolor" value="{{ $details->productImages->first()->color ?? '' }}">
                                    <input type="hidden" name="inputsize" id="cart_inputsize" value="{{ $details->productImages->first()->size ?? '' }}">
                                    <input type="hidden" id="inputPrice" name="inputPrice" value="{{ $details->productImages->first()->price ?? $details->discount_price ?? $details->regular_price }}">

                                    <!-- Quantity Control -->
                                    <div class="mb-3">
                                        <label class="d-block mb-2" style="font-weight: 600;">Quantity:</label>
                                        <div class="quantity-control-wrapper d-flex align-items-center" style="max-width: 150px;">
                                            <button type="button"
                                                    class="quantity-btn decrement-btn"
                                                    onclick="decrementQuantity()"
                                                    style="width: 40px; height: 40px; border: 1px solid #ddd; background: #f8f9fa; cursor: pointer; font-size: 18px; font-weight: bold;">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number"
                                                   name="inputQty"
                                                   id="inputQty"
                                                   value="1"
                                                   min="1"
                                                   readonly
                                                   style="width: 60px; height: 40px; text-align: center; border-left: none; border-right: none; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; font-size: 16px; font-weight: 600;">
                                            <button type="button"
                                                    class="quantity-btn increment-btn"
                                                    onclick="incrementQuantity()"
                                                    style="width: 40px; height: 40px; border: 1px solid #ddd; background: #f8f9fa; cursor: pointer; font-size: 18px; font-weight: bold;">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="button_action" id="buttonAction" value="">

                                    <div class="purchase-info-outer mt-4">
                                        <div class="mb-3">
                                            <button type="submit"
                                                    name="action"
                                                    value="addToCart"
                                                    id="addToCart"
                                                    class="cart-btn-inner w-100"
                                                    style="padding: 12px; border: none; background: #28a745; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s; margin-bottom: 10px;"
                                                    onclick="setButtonAction('addToCart')">
                                                <i class="fas fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit"
                                                    name="action"
                                                    value="buyNow"
                                                    id="buyNow"
                                                    class="cart-btn-inner w-100"
                                                    style="padding: 12px; border: none; background: var(--primary); color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;"
                                                    onclick="setButtonAction('buyNow')">
                                                <i class="fas fa-truck"></i> Order Now
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Contact Button -->
                                <div class="mt-3">
                                    <a href="tel:{{ $setting->phone ?? '+880-2-XXXXX' }}"
                                       class="product-details-hot-line w-100"
                                       style="padding: 12px; border: none; background: var(--primary); color: white; border-radius: 4px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; text-align: center;"
                                       title="Call us">
                                        <i class="fas fa-phone-alt"></i> For Call: {{ $setting->phone ?? '+880-2-XXXXX' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Tabs -->
                    <div class="product-details-info mt-5">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="true">
                                    Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-review-tab" data-bs-toggle="pill" data-bs-target="#pills-review" type="button" role="tab" aria-controls="pills-review" aria-selected="false">
                                    Review
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-policy-tab" data-bs-toggle="pill" data-bs-target="#pills-policy" type="button" role="tab" aria-controls="pills-policy" aria-selected="false">
                                    Product Policy
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                                {!! $details->long_description ?? 'No description available' !!}
                            </div>
                            <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                                @forelse ($details->reviews as $review)
                                <div class="review-item-wrapper">
                                    <div class="review-item-left">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="review-item-right">
                                        <h4 class="review-author-name">
                                            {{$review->name}}
                                            <span class="d-inline bg-danger badge-sm badge text-white">Verified</span>
                                        </h4>
                                        <p class="review-item-message">
                                            {!!$review->message!!}
                                        </p>
                                        <span class="review-item-rating-stars">
                                            <i class="fa-star fas"></i>
                                            <i class="fa-star fas"></i>
                                            <i class="fa-star fas"></i>
                                            <i class="fa-star fas"></i>
                                            <i class="fa-star fas"></i>
                                        </span>
                                    </div>
                                </div>
                                @empty
                                <p class="text-muted">No reviews yet</p>
                                @endforelse
                            </div>
                            <div class="tab-pane fade" id="pills-policy" role="tabpanel" aria-labelledby="pills-policy-tab">
                                {!! $details->policy ?? 'No policy information available' !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <div class="col-lg-4 col-md-12">
                <div class="product-details-sidebar">
                    <div class="product-details-categoris mb-4">
                        <h3 class="product-details-title">Category</h3>
                        @forelse ($categories as $category)
                        <a href="{{ url('products/' . $category->slug) }}" class="category-item-outer d-block mb-2" style="text-decoration: none; color: var(--primary);">
                            <img src="{{ asset('category/' . $category->image) }}" alt="{{ $category->name }}" style="height: 50px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                            {{ $category->name }}
                        </a>
                        @empty
                        <p class="text-muted">No categories available</p>
                        @endforelse
                    </div>

                    <!-- Category Banner -->
                    @if($details->category)
                    <div class="banner-item-outer side-banner mb-4" style="background: var(--category-bg); border-radius: 8px; overflow: hidden; padding: 20px;">
                        @if($details->category->image)
                        <img src="{{ asset('category/' . $details->category->image) }}" alt="{{ $details->category->name }}" style="height: 150px; width: 100%; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
                        @endif
                        <div class="banner-content">
                            <h4 style="color: white; margin-bottom: 10px;">{{ $details->category->name ?? 'General' }}</h4>
                            <a href="{{ url('products/' . ($details->category->slug ?? 'all')) }}" class="shop-now-btn" style="color: white; text-decoration: none; font-weight: 600;">
                                Shop Now <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<section class="releted-product-section">
    <div class="container">
        <div class="section-title-outer">
            <h1 class="title">
                Related Products
            </h1>
        </div>
        <div class="row">
            <div class="related-product-items-wrap owl-carousel">
                @forelse ($related as $product)
                <div class="product-item-wrapper">
                    <div class="product-image-outer">
                        <a href="{{url('product/'.$product->slug)}}" class="product-imgae">
                            <img src="{{asset('product/images/'.$product->image)}}" class="main-image" alt="product image">
                        </a>
                        <div class="product-badges hot">
                            <span style="text-transform: capitalize">
                                {{$product->product_type}}
                            </span>
                        </div>
                    </div>
                    <div class="product-content-outer">
                        <a href="" class="product-category">
                            {{$product->category->name}}
                        </a>
                        <a href="" class="product-name">
                            {{$product->name}}
                        </a>
                        <div class="product-item-bottom">
                            <div class="product-price">
                                @if ($product->discount_price != null)
                                <span class="">{{$product->discount_price}} Tk.</span>
                                @else
                                <span class="">{{$product->regular_price}} Tk.</span>
                                @endif
                            </div>
                            <div class="add-cart">
                                <a href="{{url('/add/to/cart/'.$product->id.'/add_cart')}}" class="add-cart-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                    Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">No related products found</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Hidden inputs for Google Analytics -->
<div style="display: none;">
    <input type="text" id="product_name" value="{{ $details->name }}">
    <input type="text" id="price" value="{{ $details->regular_price }}">
    <input type="text" id="product_id" value="{{ $details->id }}">
    <input type="text" id="category" value="{{ $details->category->name ?? 'General' }}">
</div>

@endsection

@push('script')
    <!-- js -->
    <script src="{{ asset('frontend/v-2/assets/js/playground.js') }}"></script>

   <!-- Slick slider -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script
       type="text/javascript"
       src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
   ></script>

   <!-- flowbite -->
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}

    <script>
      // Quantity control functions
      function incrementQuantity() {
          const qtyInput = document.getElementById('inputQty');
          const currentValue = parseInt(qtyInput.value) || 1;
          qtyInput.value = currentValue + 1;
      }

      function decrementQuantity() {
          const qtyInput = document.getElementById('inputQty');
          const currentValue = parseInt(qtyInput.value) || 1;
          if (currentValue > 1) {
              qtyInput.value = currentValue - 1;
          }
      }

      // Color change handler
      function onColorChange(color) {
          document.getElementById('inputcolor').value = color;
          document.getElementById('cart_inputcolor').value = color;
          updatePriceAndImage();
      }

      // Size selection handler
      function onSizeChange(element) {
          const selectedPrice = element.getAttribute('data-price');
          const selectedColor = element.getAttribute('data-color');
          const selectedSize = element.getAttribute('data-size');

          // Update hidden inputs
          document.getElementById('inputsize').value = selectedSize;
          document.getElementById('cart_inputsize').value = selectedSize;

          // Update color if this size has a specific color
          if (selectedColor) {
              document.getElementById('inputcolor').value = selectedColor;
              document.getElementById('cart_inputcolor').value = selectedColor;

              // Check the corresponding color radio button
              const colorRadios = document.querySelectorAll('input[name="color"]');
              colorRadios.forEach(radio => {
                  if (radio.value === selectedColor) {
                      radio.checked = true;
                  }
              });
          }

          // Update price
          if (selectedPrice) {
              const formattedPrice = parseFloat(selectedPrice).toFixed(2);
              const discountPriceEl = document.querySelector('.discount-price');
              const regularPriceEl = document.querySelector('.regular-price');

              if (discountPriceEl) {
                  discountPriceEl.textContent = formattedPrice + ' TK.';
              } else if (regularPriceEl) {
                  regularPriceEl.textContent = formattedPrice + ' TK.';
              }

              document.getElementById('inputPrice').value = formattedPrice;
              document.getElementById('price').textContent = formattedPrice;
          }

          updateImageForVariant();
      }

      // Update image based on variant selection
      function updateImageForVariant() {
          const selectedColor = document.getElementById('inputcolor').value;
          const selectedSize = document.getElementById('inputsize').value;
          const allImages = @json($details->productImages);

          if (!allImages || allImages.length === 0) return;

          // Find matching image with exact color and size combination
          let matchingImage = allImages.find(img =>
              img.color === selectedColor && img.size === selectedSize
          );

          // If no exact match, try to find by size only
          if (!matchingImage && selectedSize) {
              matchingImage = allImages.find(img => img.size === selectedSize);
          }

          // If still no match, try to find by color only
          if (!matchingImage && selectedColor) {
              matchingImage = allImages.find(img => img.color === selectedColor);
          }

          // If still no match, use first image
          if (!matchingImage) {
              matchingImage = allImages[0];
          }

          // Update main image using Slick slider
          const mainImageSlider = document.querySelector('.slider-content');
          const thumbSlider = document.querySelector('.slider-thumb');

          if (mainImageSlider && thumbSlider && $(mainImageSlider).hasClass('slick-initialized')) {
              const imageIndex = allImages.findIndex(img => img.id === matchingImage.id);

              if (imageIndex !== -1) {
                  $(mainImageSlider).slick('slickGoTo', imageIndex);
                  $(thumbSlider).slick('slickGoTo', imageIndex);
              }
          }
      }

      function onSubmitForm(event) {
          event.preventDefault();

          // Get form values
          var product_name = document.getElementById('product_name').value;
          var price = document.getElementById('price').value;
          var product_id = document.getElementById('product_id').value;
          var category = document.getElementById('category').value;
          var buttonAction = document.getElementById('buttonAction').value;

          // Validation
          const qty = document.getElementById('inputQty').value;
          const colorRadios = document.querySelectorAll('input[name="color"]');
          const sizeRadios = document.querySelectorAll('input[name="size"]');
          const colorSelected = Array.from(colorRadios).some(radio => radio.checked);
          const sizeSelected = Array.from(sizeRadios).some(radio => radio.checked);

          // Check quantity
          if (!qty || qty < 1) {
              alert('Please select a quantity');
              return false;
          }

          // Check if at least one variant (color or size) is selected
          if (!colorSelected && !sizeSelected) {
              alert('Please select at least a color or size');
              return false;
          }

          // Show loading state on button
          const clickedButton = event.target;
          if (clickedButton && clickedButton.tagName === 'BUTTON') {
              const originalText = clickedButton.innerHTML;
              clickedButton.disabled = true;
              clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

              setTimeout(() => {
                  clickedButton.disabled = false;
                  clickedButton.innerHTML = originalText;
              }, 3000);
          }

          // Push Google Analytics event
          dataLayer = window.dataLayer || [];

          dataLayer.push({
              ecommerce: null
          });
          dataLayer.push({
              event: "add_to_cart",
              ecommerce: {
                  items: [{
                      item_name: product_name,
                      item_id: product_id,
                      price: price,
                      item_brand: "Unknown",
                      item_category: category,
                      item_variant: document.getElementById('cart_inputcolor').value + ' / ' + document.getElementById('cart_inputsize').value,
                      item_list_name: "",
                      item_list_id: "",
                      index: 0,
                      quantity: document.getElementById('inputQty').value,
                  }]
              }
          });

          // Submit the form
          setTimeout(() => {
              document.getElementById('addToCartForm').submit();
          }, 100);
      }
  </script>
  <script>
      // Function to set the value of the hidden input based on the clicked button
      function setButtonAction(action) {
          document.getElementById('buttonAction').value = action;
      }

      // Add button hover effects
      document.addEventListener('DOMContentLoaded', function() {
          const addToCartBtn = document.getElementById('addToCart');
          const buyNowBtn = document.getElementById('buyNow');

          if (addToCartBtn) {
              addToCartBtn.addEventListener('mouseover', function() {
                  this.style.background = '#218838';
                  this.style.transform = 'translateY(-2px)';
              });
              addToCartBtn.addEventListener('mouseout', function() {
                  this.style.background = '#28a745';
                  this.style.transform = 'translateY(0)';
              });
          }

          if (buyNowBtn) {
              buyNowBtn.addEventListener('mouseover', function() {
                  this.style.filter = 'brightness(1.1)';
                  this.style.transform = 'translateY(-2px)';
              });
              buyNowBtn.addEventListener('mouseout', function() {
                  this.style.filter = 'brightness(1)';
                  this.style.transform = 'translateY(0)';
              });
          }

          // Validate form before submission
          const form = document.getElementById('addToCartForm');
          if (form) {
              form.addEventListener('submit', function(e) {
                  // Validation is now handled in onSubmitForm function
                  // This listener is kept for any additional validation if needed
              });
          }
      });
  </script>
@endpush
