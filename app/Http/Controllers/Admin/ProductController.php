<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DropshippingProductRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\RelatedProduct;
use App\Models\Subcategory;
use App\Models\AddPage;
use App\Models\PageProduct;
use App\Repository\Interface\BrandInterface;
use App\Repository\Interface\CategoryInterface;
use App\Repository\Interface\ProductInterface;
use App\Repository\Interface\PageProductInterface;
use App\Repository\Interface\SubcategoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;
use DB;

class ProductController extends Controller
{
    protected $product;
    protected $page_product;
    protected $category;
    protected $subcategory;
    protected $brand;
    public function __construct(ProductInterface $product,PageProductInterface $page_product, CategoryInterface $category, SubcategoryInterface $subcategory, BrandInterface $brand)
    {
        $this->product = $product;
        $this->page_product = $page_product;
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->brand = $brand;
    }

    public function index()
    {
        $type = 'Own';
        $products = Product::orderBy('created_at', 'desc')->where('is_page_product', 0)->where('b_product_id', null)->paginate(30);
        return view('admin.products.index', compact('products','type'));
    }

    public function dropShippingProducts ()
    {
        $type = 'Dropshipping';
        $products = Product::orderBy('created_at', 'desc')->where('is_page_product', 0)->where('b_product_id','!=', null)->paginate(30);
        return view('admin.products.index', compact('products', 'type'));
    }

    public function pageProductIndex ()
    {
        $page_products = Product::orderBy('created_at', 'desc')->where('is_page_product', 1)->paginate(30);
        return view('admin.page_products.index', compact('page_products'));
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::orderBy('created_at', 'desc')->get(),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get(),
            'type' => 'Own'
        ]);
    }

    public function createVariableProduct()
    {
        return view('admin.products.create-variable-product', [
            'categories' => Category::orderBy('created_at', 'desc')->get(),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get(),
            'brands' => Brand::orderBy('created_at', 'desc')->get(),
            'type' => 'Own'
        ]);
    }

    public function createDropshippingProduct ()
    {
        return view('admin.products.create', [
            'categories' => Category::orderBy('created_at', 'desc')->get(),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get(),
            'type' => 'Dropshipping'
        ]);
    }

    public function store(ProductRequest $request)
    {
        try {
        $image = $request->file('image');
        $input['image'] = rand().'pro_main'.$request->name.'.'.$image->getClientOriginalExtension();
        $destinationPath = 'product/images';
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['image']);
        $image->move($destinationPath, $input['image']);

        if($request->type){
            //dd($request->type);
            // $product = new PageProduct();
            $product = new Product();
            $page= AddPage::find($request->type);
            // $product->type = Str::slug($page->name);
            $product->page_name = Str::slug($page->name);
            $product->is_page_product = 1;
        }
        else{
            $product = new Product();
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->seo_keyword = $request->seo_keyword;
        }

        $product->name = $request->name;
        $product->slug = str_replace(' ', '-', strtolower($request->name));
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->qty = $request->qty;
        $product->buy_price = $request->buy_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->filled('discount_price') ? $request->discount_price : null;
        $product->product_code = $request->product_code;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->policy = $request->policy;
        $product->product_type = $request->product_type;
        $product->image = $input['image'];
        $product->save();

        if(!empty($product)){
            // No gallery uploaded: reuse the main image so the details page slider is never empty
            $imageGallery = $request->gallery_image ?: [null];
            foreach($imageGallery as $image){
                if ($image) {
                    $galleryImageName = rand().$request->name.'.'.$image->extension();
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(440, 440, function ($const) {
                        $const->aspectRatio();
                    })->save('galleryImage'. '/'. $galleryImageName);
                } else {
                    $galleryImageName = $this->mainImageToGallery($product->image);
                }

                $productGalleryImage = new ProductImage();
                if($request->type){
                    $productGalleryImage->product_page_id = $product->id;
                }
                else{
                    $productGalleryImage->product_id = $product->id;
                }
                $productGalleryImage->gallery_image = $galleryImageName;
                $productGalleryImage->save();
            }
        }

        // Product color
        foreach ($this->cleanList($request->color) as $color){
            $colorName = new ProductColor();
            if(!empty($request->type)){
                $colorName->product_page_id = $product->id;
            } else {
                $colorName->product_id = $product->id;
            }
            $colorName->color = $color;
            $colorName->save();
        }
        // Product size
        foreach ($this->cleanList($request->size) as $size){
            $sizeName = new ProductSize();
            if(!empty($request->type)){
                $sizeName->product_page_id = $product->id;
            } else {
                $sizeName->product_id = $product->id;
            }
            $sizeName->size = $size;
            $sizeName->save();
        }
        if($request->type){
            return redirect()->route('page.products.index')->with('success', 'Product has been successfully created.');
        }
        return redirect()->route('products.index')->with('success', 'Product has been successfully created.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function storeVariableProduct (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'cat_id' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'regular_price' => 'required|numeric|min:0',
            'product_type' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'gallery_image' => 'required|array|min:1',
            'gallery_image.*' => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'color' => 'required|array',
            'color.*' => 'required|string',
            'size' => 'required|array',
            'size.*' => 'required|string',
        ]);

        try {
        $image = $request->file('image');
        $input['image'] = rand().'pro_main'.$request->name.'.'.$image->getClientOriginalExtension();
        $destinationPath = 'product/images';
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['image']);
        $image->move($destinationPath, $input['image']);

        if($request->type){
            //dd($request->type);
            // $product = new PageProduct();
            $product = new Product();
            $page= AddPage::find($request->type);
            // $product->type = Str::slug($page->name);
            $product->page_name = Str::slug($page->name);
            $product->is_page_product = 1;
        }
        else{
            $product = new Product();
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->seo_keyword = $request->seo_keyword;
        }

        if(isset($request->priority)){
            $checkPriority = Product::where('priority', $request->priority)->where('id','!=', $product->id)->first();
            if($checkPriority == null){
                $product->priority = $request->priority;
            }
            elseif($checkPriority != null){
                $checkPriority->priority = 1000;
                $product->priority = $request->priority;
            }
        }
        $product->is_variable = true;
        $product->name = $request->name;
        $product->slug = str_replace(' ', '-', strtolower($request->name));
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->qty = $request->qty;
        $product->buy_price = $request->buy_price;
        $product->regular_price = $request->regular_price;
        if ($request->discount_price){
            $product->discount_price = $request->discount_price;
        }
        $product->product_code = $request->product_code;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->policy = $request->policy;
        $product->product_type = $request->product_type;
        $product->image = $input['image'];
        $product->save();

        if(!empty($product)){
            if($request->gallery_image){

                $galleryImages = $request->file('gallery_image');
                $prices = $request->input('price');
                $colors = $request->input('color');
                $sizes = $request->input('size');

                foreach ($galleryImages as $index => $image) {
                    $galleryImageName = rand().$request->name.'.'.$image->extension();
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(440, 440, function ($const) {
                        $const->aspectRatio();
                    })->save('galleryImage'. '/'. $galleryImageName);

                    $productGalleryImage = new ProductImage();
                    $productGalleryImage->product_id = $product->id;  // assuming $product is available
                    $productGalleryImage->gallery_image = $galleryImageName;
                    $productGalleryImage->price = $prices[$index];
                    $productGalleryImage->color = $colors[$index];
                    $productGalleryImage->size = $sizes[$index];
                    $productGalleryImage->save();
                }
            }
        }

        // Product color
        if($request->filled('color')){
            $colors = $request->color;
            if (is_array($colors) || is_object($colors)){
                foreach ($colors as $key => $color){
                    $colorName = new ProductColor();
                    $colorName->product_id = $product->id;
                    $colorName->color = $color;
                    $colorName->save();
                }
            }
        }
        // Product size
        if ($request->filled('size')) {
            $sizes = $request->input('size');
            if (is_array($sizes) || is_object($sizes)) {
                foreach ($sizes as $size) {
                    $sizeName = new ProductSize();
                    $sizeName->product_id = $product->id;
                    $sizeName->size = $size;
                    $sizeName->save();
                }
            }
        }
        // Related product
        if($request->filled('related_product_id')){
            $relatedProducts = $request->related_product_id;
            if (is_array($relatedProducts || is_object($relatedProducts))){
                foreach ($relatedProducts as $key => $related){
                    $relatedProduct = new RelatedProduct();
                    $relatedProduct->product_id = $product->id;
                    $relatedProduct->related_product_id = $request->related_product_id[$key];
                    $relatedProduct->save();
                }
            }
        }
        if($request->type){
            return redirect()->route('page.products.index')->with('success', 'Product has been successfully created.');
        }
        return redirect()->route('products.index')->with('success', 'Product has been successfully created.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create variable product: ' . $e->getMessage());
        }
    }

    public function storeDropshippingProduct (DropshippingProductRequest $request)
    {
        try {
        $image = $request->file('image');
        $input['image'] = rand().'pro_main'.$request->name.'.'.$image->getClientOriginalExtension();
        $destinationPath = 'product/images';
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['image']);
        $image->move($destinationPath, $input['image']);

        if($request->type){
            //dd($request->type);
            // $product = new PageProduct();
            $product = new Product();
            $page= AddPage::find($request->type);
            // $product->type = Str::slug($page->name);
            $product->page_name = Str::slug($page->name);
            $product->is_page_product = 1;
        }
        else{
            $product = new Product();
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->seo_keyword = $request->seo_keyword;
        }

        $product->b_product_id = $request->b_product_id;
        $product->name = $request->name;
        $product->slug = str_replace(' ', '-', strtolower($request->name));
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->qty = $request->qty;
        $product->buy_price = $request->buy_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->filled('discount_price') ? $request->discount_price : null;
        $product->product_code = $request->product_code;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->policy = $request->policy;
        $product->product_type = $request->product_type;
        $product->image = $input['image'];
        $product->save();

        if(!empty($product)){
            // No gallery uploaded: reuse the main image so the details page slider is never empty
            $imageGallery = $request->gallery_image ?: [null];
            foreach($imageGallery as $image){
                if ($image) {
                    $galleryImageName = rand().$request->name.'.'.$image->extension();
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(440, 440, function ($const) {
                        $const->aspectRatio();
                    })->save('galleryImage'. '/'. $galleryImageName);
                } else {
                    $galleryImageName = $this->mainImageToGallery($product->image);
                }

                $productGalleryImage = new ProductImage();
                $productGalleryImage->product_id = $product->id;
                $productGalleryImage->gallery_image = $galleryImageName;
                $productGalleryImage->save();
            }
        }

        // Product color
        foreach ($this->cleanList($request->color) as $color){
            $colorName = new ProductColor();
            $colorName->product_id = $product->id;
            $colorName->color = $color;
            $colorName->save();
        }
        // Product size
        foreach ($this->cleanList($request->size) as $size){
            $sizeName = new ProductSize();
            $sizeName->product_id = $product->id;
            $sizeName->size = $size;
            $sizeName->save();
        }
        if($request->type){
            return redirect()->route('page.products.index')->with('success', 'Product has been successfully created.');
        }
        return redirect()->route('products.dropshipping')->with('success', 'Product has been successfully created.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create dropshipping product: ' . $e->getMessage());
        }
    }

    public function storeDropshippingVariableProduct (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'cat_id' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'regular_price' => 'required|numeric|min:0',
            'product_type' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'gallery_image' => 'required|array|min:1',
            'gallery_image.*' => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
            'color' => 'nullable|array',
            'color.*' => 'nullable|string',
            'size' => 'nullable|array',
            'size.*' => 'nullable|string',
        ]);

        try {
        $image = $request->file('image');
        $input['image'] = rand().'pro_main'.$request->name.'.'.$image->getClientOriginalExtension();
        $destinationPath = 'product/images';
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(240, 240, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['image']);
        $image->move($destinationPath, $input['image']);

        if($request->type){
            //dd($request->type);
            // $product = new PageProduct();
            $product = new Product();
            $page= AddPage::find($request->type);
            // $product->type = Str::slug($page->name);
            $product->page_name = Str::slug($page->name);
            $product->is_page_product = 1;
        }
        else{
            $product = new Product();
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->seo_keyword = $request->seo_keyword;
        }

        if(isset($request->priority)){
            $checkPriority = Product::where('priority', $request->priority)->where('id','!=', $product->id)->first();
            if($checkPriority == null){
                $product->priority = $request->priority;
            }
            elseif($checkPriority != null){
                $checkPriority->priority = 1000;
                $product->priority = $request->priority;
            }
        }
        $product->b_product_id = $request->b_product_id;
        $product->is_variable = true;
        $product->name = $request->name;
        $product->vendor_id = $request->vendor_id;
        $product->slug = str_replace(' ', '-', strtolower($request->name));
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->qty = $request->qty;
        $product->buy_price = $request->buy_price;
        $product->regular_price = $request->regular_price;
        if ($request->discount_price){
            $product->discount_price = $request->discount_price;
        }
        $product->product_code = $request->product_code;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->policy = $request->policy;
        $product->product_type = $request->product_type;
        $product->image = $input['image'];
        $product->save();

        if(!empty($product)){
            if($request->gallery_image){

                $galleryImages = $request->file('gallery_image');
                $prices = $request->input('price');
                $colors = $request->input('color');
                $sizes = $request->input('size');

                foreach ($galleryImages as $index => $image) {
                    $galleryImageName = rand().$request->name.'.'.$image->extension();
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(440, 440, function ($const) {
                        $const->aspectRatio();
                    })->save('galleryImage'. '/'. $galleryImageName);

                    $productGalleryImage = new ProductImage();
                    $productGalleryImage->product_id = $product->id;  // assuming $product is available
                    $productGalleryImage->gallery_image = $galleryImageName;
                    $productGalleryImage->price = $prices[$index];
                    $productGalleryImage->color = $colors[$index];
                    $productGalleryImage->size = $sizes[$index];
                    $productGalleryImage->save();
                }
            }
        }

        // Product color
        if($request->filled('color')){
            $colors = $request->color;
            if (is_array($colors) || is_object($colors)){
                foreach ($colors as $key => $color){
                    $colorName = new ProductColor();
                    $colorName->product_id = $product->id;
                    $colorName->color = $color;
                    $colorName->save();
                }
            }
        }
        // Product size
        if ($request->filled('size')) {
            $sizes = $request->input('size');
            if (is_array($sizes) || is_object($sizes)) {
                foreach ($sizes as $size) {
                    $sizeName = new ProductSize();
                    $sizeName->product_id = $product->id;
                    $sizeName->size = $size;
                    $sizeName->save();
                }
            }
        }
        // Related product
        if($request->filled('related_product_id')){
            $relatedProducts = $request->related_product_id;
            if (is_array($relatedProducts || is_object($relatedProducts))){
                foreach ($relatedProducts as $key => $related){
                    $relatedProduct = new RelatedProduct();
                    $relatedProduct->product_id = $product->id;
                    $relatedProduct->related_product_id = $request->related_product_id[$key];
                    $relatedProduct->save();
                }
            }
        }
        if($request->type){
            return redirect()->route('page.products.index')->with('success', 'Product has been successfully created.');
        }
        return redirect()->route('products.dropshipping')->with('success', 'Product has been successfully created.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create dropshipping variable product: ' . $e->getMessage());
        }
    }

    public function edit($id, $slug)
    {
        $product = $this->product->edit($id);

        return view('admin.products.edit', [
            'categories' => Category::orderBy('created_at', 'desc')->get(),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get(),
            'product' => $product
        ]);
    }

    public function galleryImageDelete ($id)
    {
        $galleryImage = ProductImage::find($id);

        if ($galleryImage->gallery_image && file_exists(('galleryImage/').$galleryImage['gallery_image'])){
            unlink('galleryImage/'.$galleryImage->gallery_image);
        }

        $galleryImage->delete();
        return redirect()->back();
    }

    public function galleryImageEdit ($id)
    {
        $galleryImage = ProductImage::find($id);
        $product = Product::find($galleryImage->product_id);
        $productslug = $product->slug;
        return view ('admin.products.single-gallery', compact('galleryImage', 'productslug', 'product'));
    }

    public function galleryImageUpdate (Request $request, $id)
    {
        $this->validate($request, [
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        try {
        $galleryImage = ProductImage::find($id);
        if (!$galleryImage) {
            return redirect()->back()->with('error', 'Gallery image not found.');
        }
        $product = Product::find($galleryImage->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        $productslug = $product->slug;

        if(isset($request->image)){
            if ($galleryImage->gallery_image && file_exists(('galleryImage/').$galleryImage['gallery_image'])){
                unlink('galleryImage/'.$galleryImage->gallery_image);
            }

            $galleryImageName = rand().$request->name.'.'.$request->image->extension();
            $imgGallery = Image::make($request->image->path());
            $imgGallery->resize(440, 440, function ($const) {
                $const->aspectRatio();
            })->save('galleryImage'. '/'. $galleryImageName);
            $imageUrl = url('galleryImage'.'/'.$galleryImageName);

            $galleryImage->gallery_image = $galleryImageName;
            $galleryImage->imageUrl = $imageUrl;
        }
        $galleryImage->price = $request->price;
        $galleryImage->color = $request->color;
        $galleryImage->size = $request->size;
        $galleryImage->save();

        if($product->is_variable == true){
            return redirect('/variable-products/edit/' . $galleryImage->product_id . '/' . $productslug);
        }
        return redirect('/products/edit/' . $galleryImage->product_id . '/' . $productslug);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update gallery image: ' . $e->getMessage());
        }
    }

    public function editVariableProduct ($id, $slug)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = Subcategory::orderBy('created_at', 'desc')->get();
        $brands = Brand::orderBy('created_at', 'desc')->get();
        $product = $this->product->edit($id);

        return view ('admin.products.edit-variable-product', compact('categories', 'subcategories', 'brands', 'product'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        try {
        $productUpdate = Product::find($id);
        if (!$productUpdate) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
        $imageUpdate = $request->file('image');
        if (isset($imageUpdate)){
            if ($imageUpdate && file_exists(('product/images/').$productUpdate['image'])){
                unlink('product/images/'.$productUpdate->image);
            }

            $updateImageName['image'] = rand().'pro_main'.$request->name.'.'.$imageUpdate->getClientOriginalExtension();
            $updateDestinationPath = 'product/images';

            $imgFile = Image::make($imageUpdate->getRealPath());

            $imgFile->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            })->save($updateDestinationPath.'/'.$updateImageName['image']);
            $imageUpdate->move($updateDestinationPath, $updateImageName['image']);
            $productUpdate->image = $updateImageName['image'];
        }

        $productUpdate->name = $request->name;
        $productUpdate->slug = str_replace(' ', '-', strtolower($request->name));
        $productUpdate->cat_id = $request->cat_id;
        $productUpdate->sub_cat_id = $request->sub_cat_id;
        $productUpdate->qty = $request->qty;
        $productUpdate->buy_price = $request->buy_price;
        $productUpdate->regular_price = $request->regular_price;
        $productUpdate->discount_price = $request->filled('discount_price') ? $request->discount_price : null;
        $productUpdate->short_description = $request->short_description;
        $productUpdate->long_description = $request->long_description;
        $productUpdate->policy = $request->policy;
        $productUpdate->product_type = $request->product_type;
        $productUpdate->save();

        // Gallery images marked for removal on the edit form
        $removeIds = array_filter((array) $request->remove_gallery_ids);
        if ($removeIds) {
            $removedImages = ProductImage::where('product_id', $productUpdate->id)->whereIn('id', $removeIds)->get();
            foreach ($removedImages as $removedImage) {
                if ($removedImage->gallery_image && file_exists(public_path('galleryImage/'.$removedImage->gallery_image))) {
                    unlink(public_path('galleryImage/'.$removedImage->gallery_image));
                }
                $removedImage->delete();
            }
        }

        // New gallery images are added to the existing ones
        if($request->gallery_image){
            foreach($request->gallery_image as $image){
                $galleryImageName = rand().$request->name.'.'.$image->extension();
                $imgGallery = Image::make($image->path());
                $imgGallery->resize(440, 440, function ($const) {
                    $const->aspectRatio();
                })->save('galleryImage'. '/'. $galleryImageName);

                $productGalleryImage = new ProductImage();
                $productGalleryImage->product_id = $productUpdate->id;
                $productGalleryImage->gallery_image = $galleryImageName;
                $productGalleryImage->save();
            }
        }

        // Every gallery image removed: fall back to the main image
        if (!ProductImage::where('product_id', $productUpdate->id)->exists()) {
            $productGalleryImage = new ProductImage();
            $productGalleryImage->product_id = $productUpdate->id;
            $productGalleryImage->gallery_image = $this->mainImageToGallery($productUpdate->image);
            $productGalleryImage->save();
        }

        // Product color
        ProductColor::where('product_id', $productUpdate->id)->delete();
        foreach ($this->cleanList($request->color) as $color){
            $colorName = new ProductColor();
            $colorName->product_id = $productUpdate->id;
            $colorName->color = $color;
            $colorName->save();
        }
        // Product size
        ProductSize::where('product_id', $productUpdate->id)->delete();
        foreach ($this->cleanList($request->size) as $size){
            $sizeName = new ProductSize();
            $sizeName->product_id = $productUpdate->id;
            $sizeName->size = $size;
            $sizeName->save();
        }

        if ($productUpdate->b_product_id) {
            return redirect()->route('products.dropshipping')->with('success', 'Product has been successfully updated.');
        }
        return redirect()->route('products.index')->with('success', 'Product has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function updateVariableProduct (Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'cat_id' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'regular_price' => 'required|numeric|min:0',
            'product_type' => 'required|string',
            'long_description' => 'required|string',
        ]);

        try {
        if($request->type){
            //dd($request->type);
            // $product = new PageProduct();
            $product = new Product();
            $page= AddPage::find($request->type);
            // $product->type = Str::slug($page->name);
            $product->page_name = Str::slug($page->name);
            $product->is_page_product = 1;
        }
        else{
            $product = Product::where('id', $id)->with('productImages')->first();
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->seo_keyword = $request->seo_keyword;
        }

        if(isset($request->image)){
            $image = $request->file('image');
            $input['image'] = rand().'pro_main'.$request->name.'.'.$image->getClientOriginalExtension();
            $destinationPath = 'product/images';
            $imgFile = Image::make($image->getRealPath());
            $imgFile->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['image']);
            $image->move($destinationPath, $input['image']);
            $product->image = $input['image'];
        }

        if(isset($request->priority)){
            $checkPriority = Product::where('priority', $request->priority)->where('id','!=', $product->id)->first();
            if($checkPriority == null){
                $product->priority = $request->priority;
            }
            elseif($checkPriority != null){
                $checkPriority->priority = 1000;
                $product->priority = $request->priority;
            }
        }
        $product->name = $request->name;
        $product->slug = str_replace(' ', '-', strtolower($request->name));
        $product->cat_id = $request->cat_id;
        $product->sub_cat_id = $request->sub_cat_id;
        $product->qty = $request->qty;
        $product->buy_price = $request->buy_price;
        $product->regular_price = $request->regular_price;
        if ($request->discount_price){
            $product->discount_price = $request->discount_price;
        }
        $product->product_code = $request->product_code;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->policy = $request->policy;
        $product->product_type = $request->product_type;
        $product->save();

        if(!empty($product)){
            if($request->gallery_image){
                //Delete Previous Image...
                $prevousImage = ProductImage::where('product_id', $id)->get();
                if(!empty($prevousImage)){
                    foreach($prevousImage as $image){
                        $image->delete();
                    }
                }
                //Delete Previous Image...
                $galleryImages = $request->file('gallery_image');
                $prices = $request->input('price');
                $colors = $request->input('color');
                $sizes = $request->input('size');

                foreach ($galleryImages as $index => $image) {
                    $galleryImageName = rand().$request->name.'.'.$image->extension();
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(440, 440, function ($const) {
                        $const->aspectRatio();
                    })->save('galleryImage'. '/'. $galleryImageName);

                    $productGalleryImage = new ProductImage();
                    $productGalleryImage->product_id = $product->id;  // assuming $product is available
                    $productGalleryImage->gallery_image = $galleryImageName;
                    $productGalleryImage->price = $prices[$index];
                    $productGalleryImage->color = $colors[$index];
                    $productGalleryImage->size = $sizes[$index];
                    $productGalleryImage->save();
                }
            }
        }

        // Product color
        if($request->filled('color')){
            $colors = $request->color;
            if (is_array($colors) || is_object($colors)){
                foreach ($colors as $key => $color){
                    $colorName = new ProductColor();
                    $colorName->product_id = $product->id;
                    $colorName->color = $color;
                    $colorName->save();
                }
            }
        }
        // Product size
        if ($request->filled('size')) {
            $sizes = $request->input('size');
            if (is_array($sizes) || is_object($sizes)) {
                foreach ($sizes as $size) {
                    $sizeName = new ProductSize();
                    $sizeName->product_id = $product->id;
                    $sizeName->size = $size;
                    $sizeName->save();
                }
            }
        }
        // Related product
        if($request->filled('related_product_id')){
            $relatedProducts = $request->related_product_id;
            if (is_array($relatedProducts || is_object($relatedProducts))){
                foreach ($relatedProducts as $key => $related){
                    $relatedProduct = new RelatedProduct();
                    $relatedProduct->product_id = $product->id;
                    $relatedProduct->related_product_id = $request->related_product_id[$key];
                    $relatedProduct->save();
                }
            }
        }
        if($request->type){
            return redirect()->route('page.products.index')->with('success', 'Product has been successfully created.');
        }
        return redirect()->route('products.index')->with('success', 'Product has been successfully created.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update variable product: ' . $e->getMessage());
        }
    }

    public function active($id)
    {
        $this->product->active($id);
        return redirect()->back()->with('success', 'Product has been successfully Inactivated.');
    }

    public function inactive($id)
    {
        $this->product->inactive($id);
        return redirect()->back()->with('success', 'Product has been successfully Actived.');
    }

    public function delete($id)
    {
        $this->product->delete($id);
        return redirect()->back()->with('success', 'Product has been successfully deleted.');
    }

    public function pageProductcreate ()
    {
        return view('admin.page_products.create', [
            'categories' => Category::orderBy('created_at', 'desc')->get(),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get(),
            'brands' => Brand::orderBy('created_at', 'desc')->get(),
            'pages' => AddPage::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function pageProductEdit ($id, $slug)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = Subcategory::orderBy('created_at', 'desc')->get();
        $brands = Brand::orderBy('created_at', 'desc')->get();
        $pages = AddPage::orderBy('created_at', 'desc')->get();
        $product = Product::with(['pageSizes', 'pageColors', 'pageProductImages'])->find($id);

        return view('admin.page_products.edit', compact('categories', 'subcategories', 'brands', 'pages', 'product'));

    }

    public function pageProductUpdate (Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'cat_id' => 'required|integer',
            'qty' => 'required|integer|min:0',
            'regular_price' => 'required|numeric|min:0',
            'product_type' => 'required|string',
            'long_description' => 'required|string',
        ]);

        try {
        // $productUpdate = PageProduct::find($id);
        $productUpdate = Product::find($id);
        if (!$productUpdate) {
            return redirect('/page/products')->with('error', 'Product not found.');
        }

        // Update page_name if type is changed
        if($request->type){
            $page = AddPage::find($request->type);
            $productUpdate->page_name = Str::slug($page->name);
        }

        $imageUpdate = $request->file('image');
        if (isset($imageUpdate)){
            if ($imageUpdate && file_exists(('product/images/').$productUpdate['image'])){
                unlink('product/images/'.$productUpdate->image);
            }

            $updateImageName['image'] = rand().'pro_main'.$request->name.'.'.$imageUpdate->getClientOriginalExtension();
            $updateDestinationPath = 'product/images';

            $imgFile = Image::make($imageUpdate->getRealPath());

            $imgFile->resize(240, 240, function ($constraint) {
                $constraint->aspectRatio();
            })->save($updateDestinationPath.'/'.$updateImageName['image']);
            $imageUpdate->move($updateDestinationPath, $updateImageName['image']);
            $productUpdate->image = $updateImageName['image'];
        }

        $productUpdate->name = $request->name;
        $productUpdate->slug = str_replace(' ', '-', strtolower($request->name));
        $productUpdate->cat_id = $request->cat_id;
        $productUpdate->sub_cat_id = $request->sub_cat_id;
        $productUpdate->qty = $request->qty;
        $productUpdate->buy_price = $request->buy_price;
        $productUpdate->regular_price = $request->regular_price;
        if ($request->discount_price){
            $productUpdate->discount_price = $request->discount_price;
        }
        $productUpdate->product_code = $request->product_code;
        $productUpdate->short_description = $request->short_description;
        $productUpdate->long_description = $request->long_description;
        $productUpdate->policy = $request->policy;
        $productUpdate->product_type = $request->product_type;
        $productUpdate->save();

        if($request->gallery_image){
            $imageGallery = $request->gallery_image;
            ProductImage::where('product_page_id', $productUpdate->id)->delete();
            foreach($imageGallery as $image){
                $galleryImageName = rand().$request->name.'.'.$image->extension();
                $imgGallery = Image::make($image->path());
                $imgGallery->resize(440, 440, function ($const) {
                    $const->aspectRatio();
                })->save('galleryImage'. '/'. $galleryImageName);

                $productGalleryImage = new ProductImage();
                $productGalleryImage->product_page_id = $productUpdate->id;
                $productGalleryImage->gallery_image = $galleryImageName;
                $productGalleryImage->save();
            }
        }

        // Product color
            if(!empty($productUpdate)){
                if ($request->filled('color')){
                    $colors = $request->color;
                    ProductColor::where('product_page_id', $productUpdate->id)->delete();
                    foreach ($colors as $key => $color){
                        $colorName = new ProductColor();
                        $colorName->product_page_id = $productUpdate->id;
                        $colorName->color = $request->color[$key];
                        $colorName->save();
                    }
                }
            }
        // Product size
        if ($request->has('size')){
            if(!empty($productUpdate)){
                $sizes = $request->size;
                ProductSize::where('product_page_id', $productUpdate->id)->delete();
                foreach ($sizes as $key => $size){
                    $sizeName = new ProductSize();
                    $sizeName->product_page_id = $productUpdate->id;
                    $sizeName->size = $request->size[$key];
                    $sizeName->save();
                }
            }
        }

        return redirect('/page/products')->with('success', 'Product has been successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update page product: ' . $e->getMessage());
        }
    }

    public function productQtyUpdate(Request $request, $id)
    {
        $productQty = Product::find($id);
        $productQty->qty = $request->qty;
        $productQty->save();
        return $productQty;
    }

    //droploo Products with API...
    private function droplooHeaders()
    {
        $generalSetting = GeneralSetting::first();
        return [
            'App-Secret' => $generalSetting->droploo_app_secret,
            'App-Key' => $generalSetting->droploo_app_key,
            'Username' => $generalSetting->droploo_username,
        ];
    }

    public function droplooProductList()
    {
        $products = [];
        $page = 1;
        do {
            $response = Http::timeout(60)->withHeaders($this->droplooHeaders())
                ->get('https://dropshipper.nittoz.com/api/products', ['page' => $page]);

            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch data from API'], $response->status());
            }

            $responseData = $response->json();
            $products = array_merge($products, $responseData['products'] ?? []);
            $hasMore = (bool) ($responseData['pagination']['has_more'] ?? false);
            $page++;
        } while ($hasMore && $page <= 100);

        $imagePath = '';

        // Get all existing product IDs to check which products are already added
        $existingProductIds = Product::whereNotNull('b_product_id')->pluck('b_product_id')->toArray();
        $pendingProductIds = collect($products)->pluck('id')->diff($existingProductIds)->values()->all();

        return view('admin.products.droploo-product', compact('products', 'imagePath', 'existingProductIds', 'pendingProductIds'));
    }

    // Import a single droploo product (called one by one from the "Add All Products" modal)
    public function droplooProductImport($id)
    {
        @set_time_limit(300);

        try {
            $existing = Product::where('b_product_id', $id)->first();
            if ($existing) {
                return response()->json(['status' => 'skipped', 'message' => 'Already added']);
            }

            $response = Http::timeout(60)->withHeaders($this->droplooHeaders())
                ->get('https://dropshipper.nittoz.com/api/product/' . $id);

            if (!$response->successful()) {
                return response()->json(['status' => 'failed', 'message' => 'API error ' . $response->status()]);
            }

            $data = $response->json('product');
            $data = $data['product'] ?? $data;
            if (empty($data['name'])) {
                return response()->json(['status' => 'failed', 'message' => 'Product data not found']);
            }

            // Already created locally (same slug) but not linked yet -> just link it
            $slug = $data['slug'] ?? Str::slug($data['name']);
            $local = Product::where('slug', $slug)->whereNull('b_product_id')->first();
            if ($local) {
                $local->b_product_id = $id;
                $local->save();
                return response()->json(['status' => 'linked', 'message' => 'Linked with existing product']);
            }

            DB::beginTransaction();

            $category = $this->droplooCategory($data['category'] ?? []);
            $variants = $data['variants'] ?? [];
            $isVariable = !empty($data['has_variants']) && count($variants) > 0;
            $regular = (float) ($data['price']['regular'] ?? 0);
            $sale = (float) ($data['price']['sale'] ?? 0);

            $product = new Product();
            $product->b_product_id = $id;
            $product->is_variable = $isVariable ? 1 : 0;
            $product->name = $data['name'];
            $product->slug = $slug;
            $product->cat_id = $category->id;
            $product->sub_cat_id = optional($this->droplooSubcategory($data['subcategory'] ?? null, $category))->id;
            $product->qty = (int) ($data['inventory']['stock'] ?? 0);
            $product->buy_price = $data['price']['wholesale_price'] ?? null;
            $product->regular_price = $regular ?: $sale;
            if ($sale > 0 && $regular > 0 && $sale < $regular) {
                $product->discount_price = $sale;
            }
            $product->product_code = $data['inventory']['sku'] ?? null;
            $product->short_description = $data['short_description'] ?? null;
            $product->long_description = $data['description'] ?? '';
            $product->product_type = 'feature';
            $product->status = 1;
            $product->image = $this->droplooSaveImage($data['thumbnail'] ?? null, 'product/images', 240, 'pro_main');
            $product->save();

            if ($isVariable) {
                $colors = [];
                $sizes = [];
                foreach ($variants as $variant) {
                    $color = null;
                    $size = [];
                    foreach (($variant['attribute_value'] ?? []) as $attr => $value) {
                        if (stripos($attr, 'colo') !== false) {
                            $color = $value;
                        } else {
                            $size[] = $value;
                        }
                    }
                    $size = $size ? implode(' / ', $size) : null;

                    $row = new ProductImage();
                    $row->product_id = $product->id;
                    $row->gallery_image = $this->droplooSaveImage($variant['image'] ?? null, 'galleryImage', 440, 'gallery');
                    $row->price = $variant['price'] ?? null;
                    $row->color = $color;
                    $row->size = $size;
                    $row->save();

                    if ($color) $colors[$color] = true;
                    if ($size) $sizes[$size] = true;
                }
                foreach (array_keys($colors) as $color) {
                    $row = new ProductColor();
                    $row->product_id = $product->id;
                    $row->color = $color;
                    $row->save();
                }
                foreach (array_keys($sizes) as $size) {
                    $row = new ProductSize();
                    $row->product_id = $product->id;
                    $row->size = $size;
                    $row->save();
                }
            }

            // Variable products already get one gallery row per variant (with price/color/size)
            foreach (($isVariable ? [] : ($data['images'] ?? [])) as $img) {
                $name = $this->droplooSaveImage($img, 'galleryImage', 440, 'gallery');
                if ($name) {
                    $row = new ProductImage();
                    $row->product_id = $product->id;
                    $row->gallery_image = $name;
                    $row->save();
                }
            }

            DB::commit();
            return response()->json(['status' => 'added', 'message' => 'Added']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    // Find the local category by slug/name, or create it
    // Existing empty fields (image/banner) are filled from the API
    private function droplooCategory(array $apiCategory)
    {
        $slug = $apiCategory['slug'] ?? 'uncategorized';
        $name = $apiCategory['name'] ?: Str::headline($slug);

        $category = Category::where('slug', $slug)->first()
            ?? Category::where('name', $name)->first()
            ?? new Category();

        if (!$category->exists) {
            $category->name = $name;
            $category->slug = $slug;
            $category->status = 1;
        }
        if (empty($category->image) && !empty($apiCategory['image'])) {
            $category->image = $this->droplooSaveImage($apiCategory['image'], 'category', null, 'cat');
        }
        if (empty($category->banner) && !empty($apiCategory['banner'])) {
            $category->banner = $this->droplooSaveImage($apiCategory['banner'], 'category', null, 'banner');
        }
        if ($category->isDirty() || !$category->exists) {
            $category->save();
        }

        return $category;
    }

    // Find the local subcategory (under the category) by slug/name, or create it; fill empty image
    private function droplooSubcategory($apiSub, Category $category)
    {
        if (empty($apiSub) || !is_array($apiSub) || (empty($apiSub['slug']) && empty($apiSub['name']))) {
            return null;
        }
        $slug = $apiSub['slug'] ?? Str::slug($apiSub['name']);
        $name = $apiSub['name'] ?: Str::headline($slug);

        $sub = Subcategory::where('cat_id', $category->id)->where('slug', $slug)->first()
            ?? Subcategory::where('cat_id', $category->id)->where('name', $name)->first()
            ?? new Subcategory();

        if (!$sub->exists) {
            $sub->cat_id = $category->id;
            $sub->name = $name;
            $sub->slug = $slug;
        }
        if (empty($sub->image) && !empty($apiSub['image'])) {
            $sub->image = $this->droplooSaveImage($apiSub['image'], 'subcategory', null, 'sub');
        }
        if ($sub->isDirty() || !$sub->exists) {
            $sub->save();
        }

        return $sub;
    }

    // Download a remote image into public/$dir and return the file name ($size null = keep original)
    private function droplooSaveImage($url, $dir, $size, $prefix)
    {
        if (!$url) {
            return null;
        }
        $body = Http::timeout(60)->get($url)->body();
        $path = public_path($dir);
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
        $fileName = rand() . $prefix . Str::random(6) . '.' . $ext;
        if ($size === null) {
            file_put_contents($path . '/' . $fileName, $body);
        } else {
            Image::make($body)->resize($size, $size, function ($c) {
                $c->aspectRatio();
            })->save($path . '/' . $fileName);
        }

        return $fileName;
    }

    public function droplooProductAdd ($id)
    {
        //Is the Product Already Added....
        $product = Product::where('b_product_id', $id)->first();
        if($product != null){
            return redirect()->back()->with('error', 'Product is already added!');
        }
        //Is the Product Already Added....

        $generalSetting = GeneralSetting::first();
        $appKey = $generalSetting->droploo_app_key;
        $appSecret = $generalSetting->droploo_app_secret;
        $userName = $generalSetting->droploo_username;
        $apiUrl = 'https://dropshipper.nittoz.com/api/product/'.$id;

        $response = Http::withHeaders([
            'App-Secret' => $appSecret,
            'App-Key' => $appKey,
            'Username' => $userName,
        ])->get($apiUrl);

        if ($response->successful()) {
            $data = $response->json('product');
            $data = $data['product'] ?? $data;
            if (empty($data['name'])) {
                return redirect()->back()->with('error', 'Product data not found!');
            }

            $variants = $data['variants'] ?? [];
            $isVariable = !empty($data['has_variants']) && count($variants) > 0;

            // Normalize the API response for the add forms
            $product = [
                'id' => $data['id'],
                'name' => $data['name'],
                'qty' => $data['inventory']['stock'] ?? 0,
                'wholesale_price' => $data['price']['wholesale_price'] ?? '',
                'short_description' => $data['short_description'] ?? '',
                'long_description' => $data['description'] ?? '',
                'policy' => '',
                'is_variable' => $isVariable ? 1 : 0,
                'product_images' => collect($variants)->map(function ($v) {
                    $color = null;
                    $size = [];
                    foreach (($v['attribute_value'] ?? []) as $attr => $value) {
                        if (stripos($attr, 'colo') !== false) {
                            $color = $value;
                        } else {
                            $size[] = $value;
                        }
                    }
                    return [
                        'wholesale_price' => $v['wholesale_price'] ?? '',
                        'color' => $color,
                        'size' => implode(' / ', $size),
                    ];
                })->all(),
            ];

            $categories = Category::orderBy('name', 'asc')->get();
            $subcategories = Subcategory::orderBy('name', 'asc')->get();
            if($isVariable){
                return view('admin.products.droploo-variable-product', compact('product', 'categories', 'subcategories'));
            }
            else{
                return view('admin.products.droploo-product-add', compact('product', 'categories', 'subcategories'));
            }
        }

        else {
            return response()->json(['error' => 'Failed to fetch data from API'], $response->status());
        }
    }
}
