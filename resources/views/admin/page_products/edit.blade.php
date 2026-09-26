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
                                    <a href="{{ route('page.products.index') }}" class="btn btn-primary btn-sm">Products</a>
                                </div>
                            </div>

                            <form action="{{ route('page.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="padding-bottom: 5px;font-weight: 600;font-size: 15px;letter-spacing: 1px;">Page Name <small style="color: red; font-size: 18px;">*</small></label>
                                            <select class="form-control" name="type" id="type">
                                                <option disabled>Select a page</option>
                                                @foreach ($pages as $page)
                                                    <option value="{{ $page->id }}" {{ $product->page_name == \Illuminate\Support\Str::slug($page->name) ? 'selected' : '' }}>{{ $page->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red"> {{ $errors->has('type') ? $errors->first('type') : ' ' }}</span>
                                        </div>
                                    </div>
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
                                                <div class="form-group">
                                                    <label>Qty <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="qty" value="{{ $product->qty }}" class="form-control" placeholder="Product qty">
                                                    <span style="color: red"> {{ $errors->has('qty') ? $errors->first('qty') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Sale Price <small style="color: red; font-size: 18px;">*</small></label>
                                                    <input type="number" name="regular_price" value="{{ $product->regular_price }}" class="form-control" placeholder="Product regular price">
                                                    <span style="color: red"> {{ $errors->has('regular_price') ? $errors->first('regular_price') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Buy Price (Optional)</label>
                                                    <input type="number" name="buy_price" value="{{ $product->buy_price ?? '' }}" class="form-control" placeholder="Product buy price">
                                                    <span style="color: red"> {{ $errors->has('buy_price') ? $errors->first('buy_price') : ' ' }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Discount Price (Optional)</label>
                                                    <input type="text" name="discount_price" value="{{ $product->discount_price ?? '' }}"
                                                    class="form-control" placeholder="Product discount price">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>SKU ( Optional )</label>
                                                    <input type="text" name="sku" value="{{ $product->sku }}" class="form-control" placeholder="Product sku">
                                                    <span style="color: red"> {{ $errors->has('sku') ? $errors->first('sku') : ' ' }}</span>
                                                </div>
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
                                                    @foreach ($product->pageProductImages as $gallery)
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
                                                    <input type="text" name="size[]" class="form-control" placeholder="Product size">
                                                    <span style="color: red"> {{ $errors->has('size') ? $errors->first('size') : ' ' }}</span>
                                                    <button class="btn btn-sm btn-success" type="button" id="addMoreSize">
                                                        <i class="bx bx-plus-circle" aria-hidden="true" style="margin-left: 7px;"></i>
                                                    </button>
                                                </div>
                                                <div id="newRowForSize"></div>
                                                @foreach ($product->pageSizes as $size)
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="size[]" value="{{ $size->size }}" class="form-control" placeholder="Product size">
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
                                                @foreach ($product->pageColors as $color)
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="color[]" value="{{ $color->color }}" class="form-control" placeholder="Product color">
                                                        <a href="{{ url('/product/color/delete/'.$color->id) }}" class="btn btn-sm btn-danger" type="button">
                                                            <i class="bx bx-trash-alt" aria-hidden="true" style="margin-left: 7px;"></i>
                                                        </a>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short description <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="form-control" rows="5" name="short_description"
                                                placeholder="Enter product short description">{{ $product->short_description }}</textarea>
                                                <span style="color: red"> {{ $errors->has('short_description') ? $errors->first('short_description') : ' ' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Long description <small style="color: red; font-size: 18px;">*</small></label>
                                                <textarea class="ckeditor" name="long_description">{{ $product->long_description }}</textarea>
                                                <span style="color: red"> {{ $errors->has('long_description') ? $errors->first('long_description') : ' ' }}</span>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-2 float-right">Submit</button>
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
        $('#addMore').click(function(){
            let html = '';
            html+='<div class="input-group mb-3 removeRow">'
                html+='<input type="file" name="gallery_image[]" class="form-control">'
                html+='<button class="btn btn-sm btn-danger removeBtn" type="button">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '.removeBtn', function () {
            $(this).closest('.removeRow').remove();
        });

        $('#addMoreSize').click(function(){
            let html = '';
            html+='<div class="input-group mb-3 removeSizeRow">'
                html+='<input type="text" name="size[]" class="form-control" placeholder="Product size">'
                html+='<button class="btn btn-sm btn-danger removeSizeBtn" type="button">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForSize').append(html);
        });

        // remove row
        $(document).on('click', '.removeSizeBtn', function () {
            $(this).closest('.removeSizeRow').remove();
        });

        $('#addMoreColor').click(function(){
            let html = '';
            html+='<div class="input-group mb-3 removeColorRow">'
                html+='<input type="text" name="color[]" class="form-control" placeholder="Product color">'
                html+='<button class="btn btn-sm btn-danger removeColorBtn" type="button">'
                    html+='<i class="bx bx-minus" aria-hidden="true" style="margin-left: 7px;"></i>'
                html+='</button>'
            html+='</div>'

            $('#newRowForColor').append(html);
        });

        // remove row
        $(document).on('click', '.removeColorBtn', function () {
            $(this).closest('.removeColorRow').remove();
        });
    </script>
@endpush
