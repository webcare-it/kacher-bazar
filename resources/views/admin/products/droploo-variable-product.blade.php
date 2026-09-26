@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-3">Add New Product</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Products</a>
                                </div>
                            </div>

                            <form action="{{ url('/dropshipping-variable-products/store') }}" method="post" enctype="multipart/form-data" id="productForm">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <input type="hidden" name="b_product_id" value="{{ $product['id'] }}" class="form-control" placeholder="Product ID From Banggomart...">
                                            <div class="col-md-6">
{{--                                                <div class="form-group">--}}
{{--                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Priority</label>--}}
{{--                                                    <input type="text" name="priority" value="{{ old('priority') }}" class="form-control" placeholder="Product priority"><br>--}}
{{--                                                    <span style="color: red"> {{ $errors->has('priority') ? $errors->first('priority') : ' ' }}</span>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Name <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="name" value="{{ $product['name'] }}" class="form-control" placeholder="Product name"><br>
                                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Category Name <small style="color: red; font-size: 18px;">*</small></label>
                                                    <select class="form-control" name="cat_id" id="cat_id" onchange="categoryWiseSubcategory(this.value)">
                                                        <option selected disabled>Select a category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span style="color: red"> {{ $errors->has('cat_id') ? $errors->first('cat_id') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Subcategory Name</label>
                                                    <select class="form-control" name="sub_cat_id" id="sub_cat_id">
                                                        <option selected disabled>Select a Subcategory</option>
                                                    </select>
                                                    <span style="color: red"> {{ $errors->has('sub_cat_id') ? $errors->first('sub_cat_id') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Qty <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="qty" value="{{ $product['qty'] }}" class="form-control" placeholder="Product qty"><br>
                                                    <span style="color: red"> {{ $errors->has('qty') ? $errors->first('qty') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Whole Sale Price</label>
                                                    <input type="text" name="buy_price" value="{{ $product['wholesale_price'] ?? '' }}"
                                                    class="form-control" placeholder="" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Common Price <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="regular_price" value="{{ old('regular_price') }}" class="form-control" placeholder="Product regular price"><br>
                                                    <span style="color: red"> {{ $errors->has('regular_price') ? $errors->first('regular_price') : ' ' }}</span>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Discount Price (Optional)</label>
                                                    <input type="text" name="discount_price" value="{{ old('discount_price') }}"
                                                    class="form-control" placeholder="Product discount price"><br>
                                                </div> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Code ( Optional )</label>
                                                    <input type="text" name="product_code " value="{{ old('product_code ') }}" class="form-control" placeholder="Product code"><br>
                                                    <span style="color: red"> {{ $errors->has('product_code ') ? $errors->first('product_code ') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Rating => 1 to 5 ( Optional )</label>
                                                    <input type="text" name="rating" value="{{ old('rating') }}" class="form-control" placeholder="Product code"><br>
                                                    <span style="color: red"> {{ $errors->has('rating') ? $errors->first('rating') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Main image <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="image" id="image" class="form-control"><br>
                                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                                </div>
                                                <label style="padding-bottom: 5px; font-weight: 600; font-size: 15px; letter-spacing: 1px;">
                                                    Gallery Image, Price, Color, and Size
                                                    <small style="color: red; font-size: 18px;">*</small>
                                                </label>

                                                @if(isset($product['product_images']) && count($product['product_images']) > 0)
                                                    @foreach($product['product_images'] as $image)
                                                        <div class="row g-2 align-items-center mb-2 removeRow">
                                                            <!-- Gallery Image -->
                                                            <div class="col-md-4">
                                                                <label for="">Gallery Image <span class="text-danger">*</span></label>
                                                                <input type="file" name="gallery_image[]" class="form-control" required>
                                                            </div>

                                                            <!-- Wholesale Price -->
                                                            <div class="col-md-2">
                                                                <label for="">Wholesale Price</label>
                                                                <input type="text" name="wholesale_price_variable[]" class="form-control" placeholder="Wholesale Price"
                                                                       value="{{ $image['wholesale_price'] ?? '' }}" disabled>
                                                            </div>

                                                            <!-- Retail Price -->
                                                            <div class="col-md-2">
                                                                <label for="">Retail Price <span class="text-danger">*</span></label>
                                                                <input type="text" name="price[]" class="form-control" placeholder="Price" value="" required>
                                                            </div>

                                                            <!-- Color -->
                                                            <div class="col-md-2">
                                                                <label for="">Color</label>
                                                                <input type="text" name="color[]" class="form-control" placeholder="Color"
                                                                       value="{{ $image['color'] ?? '' }}" readonly>
                                                            </div>

                                                            <!-- Size -->
                                                            <div class="col-md-2">
                                                                <label for="">Size</label>
                                                                <input type="text" name="size[]" class="form-control" placeholder="Size"
                                                                       value="{{ $image['size'] ?? '' }}" readonly>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="row g-2 align-items-center mb-2 removeRow">
                                                        <div class="col-md-3">
                                                            <label for="">Gallery Image <span class="text-danger">*</span></label>
                                                            <input type="file" name="gallery_image[]" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Wholesale Price</label>
                                                            <input type="text" name="wholesale_price_variable[]" class="form-control" placeholder="Wholesale Price">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Retail Price</label>
                                                            <input type="text" name="price[]" class="form-control" placeholder="Price">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Color</label>
                                                            <input type="text" name="color[]" class="form-control" placeholder="Color">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Size</label>
                                                            <input type="text" name="size[]" class="form-control" placeholder="Size">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label for="">&nbsp;</label>
                                                            <button class="btn btn-sm btn-primary d-block" type="button" id="addMore">
                                                                <i class="bx bx-plus-circle" style="margin-left: 3px;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div id="newRow"></div>

                                                <span style="color: red"> {{ $errors->first('gallery_image') }}</span>
                                                <span style="color: red"> {{ $errors->first('price') }}</span>
                                                <span style="color: red"> {{ $errors->first('color') }}</span>
                                                <span style="color: red"> {{ $errors->first('size') }}</span>
                                                <div id="newRowForColor"></div>

                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Related Product ( Optional )</label>
                                                <select class="multiple-related-product form-control mb-3" name="related_product_id[]" multiple="multiple">
                                                  <option value="AL">Select A Related Product</option>
                                                    @foreach(\App\Models\Product::orderBy('created_at', 'desc')->get() as $relatedproduct)
                                                        <option value="{{ $relatedproduct->id }}">{{ $relatedproduct->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Short description</label>
                                                <textarea class="form-control" rows="5" name="short_description" placeholder="Enter product short description">{{ $product['short_description'] }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('short_description') ? $errors->first('short_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Long description <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="ckeditor" name="long_description">{{ $product['long_description'] }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('long_description') ? $errors->first('long_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Policy <small style="color: red; font-size: 18px;"></small></label>
                                                <textarea class="ckeditor" name="policy">{{ $product['policy'] }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('policy') ? $errors->first('policy') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Video Link (Optional) <small style="color: red; font-size: 18px;"></small></label>
                                                <input type="text" name="video_link" value="" class="form-control" placeholder="Only source link..">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product type <small style="color: red; font-size: 18px;">*</small></label>
                                                <select class="form-control" name="product_type" id="product_type">
                                                    <option selected disabled>Select a product type</option>
                                                    <option value="feature">Regular Product</option>
                                                    <option value="hot">Hot Product</option>
                                                    <option value="discount">Discount Product</option>
                                                    <option value="new">New Arrival Product</option>
                                                </select><br>
                                                <span style="color: red"> {{ $errors->has('product_type') ? $errors->first('product_type') : ' ' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 additional-info-form">
                                        <div class="additional-info-wrapper">
                                            <div class="additional-info-title">
                                                <h6 class="info-title">
                                                    SEO Information
                                                </h6>
                                            </div>
                                            <hr>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Title ( Optional )</label><br>
                                            <input type="text" name="seo_title" class="form-control" value="" placeholder="Seo title"><br>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Description ( Optional )</label><br>
                                            <textarea rows="4" name="seo_description" class="form-control" placeholder="Seo description"></textarea><br>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Keyword ( Optional )</label><br>
                                            <select type="text" class="form-control" id="multipleTag" name="seo_keyword" multiple="multiple" value=""></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-2 float-right" id="submitBtn">Submit</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script>
        // Form validation before submission
        $('#productForm').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';
            
            // Validate Name
            if (!$('input[name="name"]').val().trim()) {
                isValid = false;
                errorMessage += 'Product Name is required\n';
                $('input[name="name"]').css('border', '2px solid red');
            } else {
                $('input[name="name"]').css('border', '');
            }
            
            // Validate Category
            if (!$('select[name="cat_id"]').val()) {
                isValid = false;
                errorMessage += 'Category is required\n';
                $('select[name="cat_id"]').css('border', '2px solid red');
            } else {
                $('select[name="cat_id"]').css('border', '');
            }
            
            // Validate Quantity
            if (!$('input[name="qty"]').val().trim()) {
                isValid = false;
                errorMessage += 'Quantity is required\n';
                $('input[name="qty"]').css('border', '2px solid red');
            } else {
                $('input[name="qty"]').css('border', '');
            }
            
            // Validate Common Price
            if (!$('input[name="regular_price"]').val().trim()) {
                isValid = false;
                errorMessage += 'Common Price is required\n';
                $('input[name="regular_price"]').css('border', '2px solid red');
            } else {
                $('input[name="regular_price"]').css('border', '');
            }
            
            // Validate Product Type
            if (!$('select[name="product_type"]').val()) {
                isValid = false;
                errorMessage += 'Product Type is required\n';
                $('select[name="product_type"]').css('border', '2px solid red');
            } else {
                $('select[name="product_type"]').css('border', '');
            }
            
            // Validate Long Description (CKEditor)
            let editorData = $('.ckeditor').first().val();
            if (!editorData || editorData.trim() === '' || editorData === '<p><br></p>') {
                isValid = false;
                errorMessage += 'Long Description is required\n';
            }
            
            // Validate at least one gallery image row has an image
            let galleryImages = $('input[name="gallery_image[]"]');
            let hasGalleryImage = false;
            galleryImages.each(function() {
                if ($(this).val()) {
                    hasGalleryImage = true;
                    return false;
                }
            });
            
            if (!hasGalleryImage) {
                isValid = false;
                errorMessage += 'At least one Gallery Image is required\n';
                galleryImages.first().css('border', '2px solid red');
            } else {
                galleryImages.css('border', '');
            }
            
            // Validate at least one retail price is filled
            let prices = $('input[name="price[]"]');
            let hasPrice = false;
            prices.each(function() {
                if ($(this).val().trim()) {
                    hasPrice = true;
                    return false;
                }
            });
            
            if (!hasPrice) {
                isValid = false;
                errorMessage += 'At least one Retail Price is required\n';
                prices.first().css('border', '2px solid red');
            } else {
                prices.css('border', '');
            }
            
            // If validation fails, prevent submission
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields:\n' + errorMessage);
                return false;
            }
            
            // Disable submit button to prevent double submission
            $('#submitBtn').prop('disabled', true).text('Submitting...');
        });
        
        // Remove red border on input focus
        $('input, select, textarea').on('focus', function() {
            $(this).css('border', '');
        });
    </script>
    <script>
        $('#addMore').click(function () {
            let html = `
            <div class="row g-2 align-items-center mb-2 removeRow">
                <div class="col-md-3">
                    <input type="file" name="gallery_image[]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="wholesale_price_variable[]" class="form-control" placeholder="Wholesale Price" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="price[]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-2">
                    <input type="text" name="color[]" class="form-control" placeholder="Color">
                </div>
                <div class="col-md-2">
                    <input type="text" name="size[]" class="form-control" placeholder="Size">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-danger remove" type="button">
                        <i class="bx bx-minus"></i>
                    </button>
                </div>
            </div>
        `;

            $('#newRow').append(html);
        });

        // Remove row
        $(document).on('click', '.remove', function () {
            $(this).closest('.removeRow').remove();
        });
    </script>
@endpush
