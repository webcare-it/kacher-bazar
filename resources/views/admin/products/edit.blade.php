@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Update Product</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Products</a>
                                </div>
                            </div>

                            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data" id="productForm">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Name <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Product name">
                                                    <span style="color: red"> {{ $errors->has('name') ? $errors->first('name') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Category Name <small style="color: red; font-size: 18px;">*</small></label>
                                                    <select class="form-control" name="cat_id" id="cat_id" onchange="categoryWiseSubcategory(this.value)">
                                                        <option selected disabled>Select a category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span style="color: red"> {{ $errors->has('cat_id') ? $errors->first('cat_id') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Subcategory Name</label>
                                                    <select class="form-control" name="sub_cat_id" id="sub_cat_id">
                                                        <option selected disabled>Select a Subcategory</option>
                                                        @foreach ($subcategories as $subcategory)
                                                            <option value="{{ $subcategory->id }}" {{ $product->sub_cat_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span style="color: red"> {{ $errors->has('sub_cat_id') ? $errors->first('sub_cat_id') : ' ' }}</span>
                                                </div>
{{--                                                <div class="form-group">--}}
{{--                                                    <label>Brand Name</label>--}}
{{--                                                    <select class="form-control" name="brand_id" id="brand_id">--}}
{{--                                                        <option selected disabled>Select a brand</option>--}}
{{--                                                        @foreach ($brands as $brand)--}}
{{--                                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }} >{{ $brand->name }}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    <span style="color: red"> {{ $errors->has('brand_id') ? $errors->first('brand_id') : ' ' }}</span>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <label>Qty <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="qty" value="{{ $product->qty }}" class="form-control" placeholder="Product qty">
                                                    <span style="color: red"> {{ $errors->has('qty') ? $errors->first('qty') : ' ' }}</span>
                                                </div>
                                               <div class="form-group">
                                                   <label>Buy Price</label>
                                                    <input type="number" name="buy_price" value="{{ $product->buy_price }}" class="form-control" placeholder="Product buy price">
                                                    <span style="color: red"> {{ $errors->has('buy_price') ? $errors->first('buy_price') : ' ' }}</span>
                                               </div>
                                                <div class="form-group">
                                                    <label>Sale Price <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="regular_price" value="{{ $product->regular_price }}" class="form-control" placeholder="Product regular price">
                                                    <span style="color: red"> {{ $errors->has('regular_price') ? $errors->first('regular_price') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Discount Price (Optional)</label>
                                                    <input type="text" name="discount_price" value="{{ $product->discount_price ?? '' }}"
                                                    class="form-control" placeholder="Product discount price">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Product Code ( Optional )</label>
                                                    <input type="text" name="product_code " value="{{ $product->product_code  }}" class="form-control" placeholder="Product code ">
                                                    <span style="color: red"> {{ $errors->has('product_code ') ? $errors->first('product_code ') : ' ' }}</span>
                                                </div>
{{--                                                <div class="form-group">--}}
{{--                                                    <label>Stock</label>--}}
{{--                                                    <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" placeholder="Product stock">--}}
{{--                                                    <span style="color: red"> {{ $errors->has('stock') ? $errors->first('stock') : ' ' }}</span>--}}
{{--                                                </div>--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <label>Vat/Tax</label>--}}
{{--                                                    <input type="number" name="vat_tax" value="{{ $product->vat_tax }}" class="form-control" placeholder="Product vat tax">--}}
{{--                                                    <span style="color: red"> {{ $errors->has('vat_tax') ? $errors->first('vat_tax') : ' ' }}</span>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <label>Main image <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="file" name="image" id="image" class="form-control">
                                                    <img src="{{ asset('/product/images/'.$product->image) }}" height="100" width="100" />
                                                    <span style="color: red"> {{ $errors->has('image') ? $errors->first('image') : ' ' }}</span>
                                                </div>
                                                <label>Gallery image <small style="color: red; font-size: 18px;">*</small></label>
                                                <div class="input-group mb-3">
                                                    <input type="file" name="gallery_image[]" id="gallery_image" class="form-control">
                                                    <button class="btn btn-sm btn-primary" type="button" id="addMore">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <span style="color: red"> {{ $errors->has('gallery_image') ? $errors->first('gallery_image') : ' ' }}</span>
                                                <div class="gallery-image">
                                                    @foreach ($product->productImages as $gallery)
                                                        <div style="display: inline-block; position: relative; margin: 5px;">
                                                            <img src="{{ asset('/galleryImage/'.$gallery->gallery_image) }}" height="80" width="80" />
                                                            <a href="{{ url('/gallery-image/delete/'.$gallery->id) }}" class="btn btn-sm btn-danger" style="position: absolute; top: -5px; right: -5px; padding: 2px 6px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="bx bx-trash"></i>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div id="newRow" class="mt-2"></div>

                                                  <label>Product Size ( Optional )</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="size[]" id="size" class="form-control" placeholder="Product size">
                                                    <span style="color: red"> {{ $errors->has('size') ? $errors->first('size') : ' ' }}</span>
                                                    <button class="btn btn-sm btn-success" type="button" id="addMoreSize">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <div id="newRowForSize"></div>
                                                @foreach ($product->sizes as $size)
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="size[]" id="size" value="{{ $size->size }}" class="form-control" placeholder="Product size">
                                                        <a href="{{ url('/product/size/delete/'.$size->id) }}" class="btn btn-sm btn-danger" type="button">
                                                            <i class="bx bx-trash-alt" aria-hidden="true" style="margin-left: 7px;"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                <label>Product Color ( Optional )</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="color[]" id="color" class="form-control" placeholder="Product color">
                                                    <span style="color: red"> {{ $errors->has('color') ? $errors->first('color') : ' ' }}</span>
                                                    <button class="btn btn-sm btn-info" type="button" id="addMoreColor">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <div id="newRowForColor"></div>
                                                @foreach ($product->colors as $color)
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="color[]" id="color" value="{{ $color->color }}" class="form-control" placeholder="Product color">
                                                        <a href="{{ url('/product/color/delete/'.$color->id) }}" class="btn btn-sm btn-danger" type="button">
                                                            <i class="bx bx-trash-alt" aria-hidden="true" style="margin-left: 7px;"></i>
                                                        </a>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short description</label>
                                                <textarea class="form-control" rows="5" name="short_description"
                                                placeholder="Enter product short description">{{ $product->short_description }}</textarea>
                                                <span style="color: red"> {{ $errors->has('short_description') ? $errors->first('short_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Long description <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="ckeditor" name="long_description">{{ $product->long_description }}</textarea>
                                                <span style="color: red"> {{ $errors->has('long_description') ? $errors->first('long_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Product Policy <small style="color: red; font-size: 18px;"></small></label>
                                                <textarea class="ckeditor" name="policy">{{ $product->policy }}</textarea><br>
                                                <span style="color: red"> {{ $errors->has('policy') ? $errors->first('policy') : ' ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Product type <small style="color: red; font-size: 18px;">*</small></label>
                                                <select class="form-control" name="product_type" id="product_type">
                                                    <option selected disabled>Select a product type</option>
                                                    <option value="feature" {{ $product->product_type == 'feature' ? 'selected' : '' }}>Regular Product</option>
                                                    <option value="hot" {{ $product->product_type == 'hot' ? 'selected' : '' }}>Hot Product</option>
                                                    <option value="discount" {{ $product->product_type == 'discount' ? 'selected' : '' }}>Discount Product</option>
                                                    <option value="new" {{ $product->product_type == 'new' ? 'selected' : '' }}>New Arrival Product</option>
                                                </select>
                                                <span style="color: red"> {{ $errors->has('product_type') ? $errors->first('product_type') : ' ' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 additional-info-form">
                                        <div class="additional-info-wrapper">
                                             <div class="additional-info-title">
                                                <h6 class="info-title">
                                                    SEO Information
                                                </h6>
                                            </div>
{{--                                            <label>Product Address</label><br>--}}
{{--                                            <textarea rows="4" class="form-control" name="product_address" placeholder="Product shipping from">{{ $product->product_address }}</textarea><br>--}}
{{--                                            <label for="inside">Inside Dhaka</label><br>--}}
{{--                                            <input type="text" name="inside_dhaka" class="form-control" value="{{ $product->inside_dhaka }}" placeholder="Product shipping charge"><br>--}}
{{--                                            <label for="outside">Outside Dhaka</label><br>--}}
{{--                                            <input type="text" name="outside_dhaka" class="form-control" value="{{ $product->outside_dhaka }}" placeholder="Product shipping charge"><br>--}}
{{--                                            <label>Delivery Time <small class="text-danger">( Same delivery day inside and outside Dhaka )</small></label><br>--}}
{{--                                            <input type="text" name="delivery_time" class="form-control" value="{{ $product->delivery_time ?? '' }}" placeholder="Product delivery time"><br>--}}
                                            <hr>
                                            <label>SEO Title ( Optional )</label><br>
                                            <input type="text" name="seo_title" class="form-control" value="{{ $product->seo_title ?? '' }}" placeholder="Seo title"><br>
                                            <label>SEO Description ( Optional )</label><br>
                                            <textarea rows="4" name="seo_description" class="form-control" placeholder="Seo description">{{ $product->seo_description ?? '' }}</textarea><br>
                                            <label>SEO Keyword ( Optional )</label><br>
                                            <input type="text" name="seo_keyword" value="{{ $product->seo_keyword ?? '' }}" class="form-control" placeholder="Seo keyword">
                                            <label style="padding-bottom: 5px;margin-top: 10px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Related Product ( Optional )</label>
                                            <select class="multiple-related-product form-control mb-3" name="related_product_id[]" multiple="multiple">
                                                <option value="AL">Select A Related Product</option>
                                                @foreach(\App\Models\Product::orderBy('created_at', 'desc')->get() as $relatedproduct)
                                                    <option value="{{ $relatedproduct->id }}">{{ $relatedproduct->name }}</option>
                                                @endforeach
                                            </select>
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
            
            // Validate Sale Price
            if (!$('input[name="regular_price"]').val().trim()) {
                isValid = false;
                errorMessage += 'Sale Price is required\n';
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
