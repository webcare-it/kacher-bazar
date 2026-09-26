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
                                    <h5 class="mb-3">Add {{$type}} Product</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Products</a>
                                </div>
                            </div>

                            @if ($type == 'Own')
                            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" id="productForm">
                            @elseif ($type == 'Dropshipping')
                            <form action="{{ route('dropshipping-products.store') }}" method="post" enctype="multipart/form-data" id="productForm">
                            @endif
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if ($type == 'Dropshipping')
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Dropshipping Product ID <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="b_product_id" value="{{ old('b_product_id') }}" class="form-control" placeholder="Product ID From Droploo..."><br>
                                                    <span style="color: red"> {{ $errors->has('b_product_id') ? $errors->first('b_product_id') : ' ' }}</span>
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Name <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Product name"><br>
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
{{--                                                <div class="form-group">--}}
{{--                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Brand Name</label>--}}
{{--                                                    <select class="form-control" name="brand_id" id="brand_id">--}}
{{--                                                        <option selected disabled>Select a brand</option>--}}
{{--                                                        @foreach ($brands as $brand)--}}
{{--                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span style="color: red"> {{ $errors->has('brand_id') ? $errors->first('brand_id') : ' ' }}</span>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Qty <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="qty" value="{{ old('qty') }}" class="form-control" placeholder="Product qty"><br>
                                                    <span style="color: red"> {{ $errors->has('qty') ? $errors->first('qty') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Buy Price</label>
                                                    <input type="number" name="buy_price" value="{{ old('buy_price') }}" class="form-control" placeholder="Product buy price">
                                                    <span style="color: red"> {{ $errors->has('buy_price') ? $errors->first('buy_price') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Sale Price <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="regular_price" value="{{ old('regular_price') }}" class="form-control" placeholder="Product regular price"><br>
                                                    <span style="color: red"> {{ $errors->has('regular_price') ? $errors->first('regular_price') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Discount Price (Optional)</label>
                                                    <input type="text" name="discount_price" value="{{ old('discount_price') }}"
                                                    class="form-control" placeholder="Product discount price"><br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Code ( Optional )</label>
                                                    <input type="text" name="product_code " value="{{ old('product_code ') }}" class="form-control" placeholder="Product code"><br>
                                                    <span style="color: red"> {{ $errors->has('product_code ') ? $errors->first('product_code ') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Main image <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="image" id="image" class="form-control"><br>
                                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                                </div>
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Gallery image <small style="color: red; font-size: 18px;">*</small></label>
                                                <div class="input-group mb-3">
                                                    <input type="file" name="gallery_image[]" id="gallery_image" class="form-control">
                                                    <button class="btn btn-sm btn-primary" type="button" id="addMore">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <span style="color: red"> {{ $errors->has('gallery_image') ? $errors->first('gallery_image') : ' ' }}</span>
                                                <div id="newRow"></div>

                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Size ( Optional )</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="size[]" id="size" class="form-control" placeholder="Product size">
                                                    <span style="color: red"> {{ $errors->has('size') ? $errors->first('size') : ' ' }}</span>
                                                    <button class="btn btn-sm btn-success" type="button" id="addMoreSize">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <div id="newRowForSize"></div>

                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Color ( Optional )</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="color[]" id="color" class="form-control" placeholder="Product color">
                                                    <span style="color: red"> {{ $errors->has('color') ? $errors->first('color') : ' ' }}</span>
                                                    <button class="btn btn-sm btn-info" type="button" id="addMoreColor">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <div id="newRowForColor"></div>

                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Related Product ( Optional )</label>
                                                <select class="multiple-related-product form-control mb-3" name="related_product_id[]" multiple="multiple">
                                                  <option value="AL">Select A Related Product</option>
                                                    @foreach(\App\Models\Product::orderBy('created_at', 'desc')->get() as $relatedproduct)
                                                        <option value="{{ $relatedproduct->id }}">{{ $relatedproduct->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- <div class="input-group mb-3">
                                                    <input type="text" name="product_id[]" id="product_id" multiple="multiple" class="form-control" placeholder="Related Product">
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Short description</label>
                                                <textarea class="form-control" rows="5" name="short_description" placeholder="Enter product short description">{{ old('short_description') }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('short_description') ? $errors->first('short_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Long description <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="ckeditor" name="long_description">{{ old('long_description') }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('long_description') ? $errors->first('long_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Policy <small style="color: red; font-size: 18px;"></small></label>
                                                <textarea class="ckeditor" name="policy">{{ old('policy') }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('policy') ? $errors->first('policy') : ' ' }}</span>
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
{{--                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Product Address</label><br>--}}
{{--                                           <textarea rows="4" class="form-control" name="product_address" placeholder="Product shipping from"></textarea><br>--}}
{{--                                            <label for="inside">Inside Dhaka</label><br>--}}
{{--                                            <input type="text" name="inside_dhaka" class="form-control" value="" placeholder="Product shipping charge"><br>                                            <label for="outside">Outside Dhaka</label><br>--}}
{{--                                           <input type="text" name="outside_dhaka" class="form-control" value="" placeholder="Product shipping charge"><br>--}}
{{--                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Delivery Time <small class="text-danger">( Same delivery day inside and outside Dhaka )</small></label><br>--}}
{{--                                            <input type="text" name="delivery_time" class="form-control" value="" placeholder="Product delivery time"><br>--}}
                                            <hr>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Title ( Optional )</label><br>
                                            <input type="text" name="seo_title" class="form-control" value="" placeholder="Seo title"><br>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Description ( Optional )</label><br>
                                            <textarea rows="4" name="seo_description" class="form-control" placeholder="Seo description"></textarea><br>
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">SEO Keyword ( Optional )</label><br>
                                            <select type="text" class="form-control" id="multipleTag" name="seo_keyword" multiple="multiple" value=""></select>
                                            {{-- <input type="text" name="seo_keyword" value="" id="multipleTag" class="form-control" placeholder="Seo keyword"> --}}
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
            
            // Validate Dropshipping Product ID (only for Dropshipping type)
            @if ($type == 'Dropshipping')
            if (!$('input[name="b_product_id"]').val().trim()) {
                isValid = false;
                errorMessage += 'Dropshipping Product ID is required\n';
                $('input[name="b_product_id"]').css('border', '2px solid red');
            } else {
                $('input[name="b_product_id"]').css('border', '');
            }
            @endif
            
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
            
            // Validate Sale Price
            if (!$('input[name="regular_price"]').val().trim()) {
                isValid = false;
                errorMessage += 'Sale Price is required\n';
                $('input[name="regular_price"]').css('border', '2px solid red');
            } else {
                $('input[name="regular_price"]').css('border', '');
            }
            
            // Validate Main Image
            if (!$('input[name="image"]').val()) {
                isValid = false;
                errorMessage += 'Main Image is required\n';
                $('input[name="image"]').css('border', '2px solid red');
            } else {
                $('input[name="image"]').css('border', '');
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
            let editorData = $('.ckeditor').val();
            if (!editorData || editorData.trim() === '' || editorData === '<p><br></p>') {
                isValid = false;
                errorMessage += 'Long Description is required\n';
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
        $('#addMore').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeRow">'
                html+='<input type="file" name="gallery_image[]" id="gallery_image" class="form-control">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="remove">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#remove', function () {
            $(this).closest('#removeRow').remove();
        });

        $('#addMoreSize').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeSizeRow">'
                html+='<input type="text" name="size[]" id="size" class="form-control" placeholder="Product size">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="removeSize">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForSize').append(html);
        });

        // remove row
        $(document).on('click', '#removeSize', function () {
            $(this).closest('#removeSizeRow').remove();
        });

        $('#addMoreColor').click(function(){
            let html = '';
            html+='<div class="input-group mb-3" id="removeColorRow">'
                html+='<input type="text" name="color[]" id="color" class="form-control" placeholder="Product color">'
                html+='<button class="btn btn-sm btn-danger" type="button" id="removeColor">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForColor').append(html);
        });

        // remove row
        $(document).on('click', '#removeColor', function () {
            $(this).closest('#removeColorRow').remove();
        });
    </script>
@endpush
