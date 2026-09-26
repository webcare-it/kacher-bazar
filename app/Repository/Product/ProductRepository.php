<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Repository\Interface\ProductInterface;
use App\Uploader\FileUpload;
use Illuminate\Support\Facades\Storage;
use Session;
use Intervention\Image\Facades\Image;
class ProductRepository implements ProductInterface
{
    public function getAllData()
    {
        return Product::with('category', 'subcategory', 'brand', 'productImages')->paginate(10);
    }

    public function store($data = [])
    {
        //dd($data['image']);
        if($data['image']){
            $newFile = new FileUpload();
            $productImage = $newFile->upload('product', $data['image'], ['details', 'carousel', 'small slider', 'cart image']);
        }

         if($data['image']){
             $image = $data['image'];
             $data['image'] = $data['name']. '-'.time().'.'.$image->extension();

             $filePath = 'product/images';

             $img = Image::make($image->path());
             $img->resize(240, 240, function ($const) {
                 $const->aspectRatio();
             })->save($filePath.'/240x240-'.$data['image']);

             $img->resize(540, 500, function ($const) {
                 $const->aspectRatio();
             })->save($filePath.'/540x500-'.$data['image']);
         }

//        $imageName = time().'.'.$data['image']->extension();
//        $file = $data['image'];
//        $filePath = '/assets';
//        $path = $file->storeAs($filePath, $imageName, 's3');
//        Storage::disk('s3')->setVisibility($path, 'public');
//        $path = Storage::disk('s3')->put($filePath, file_get_contents($data['image']), 's3');
//        $path = Storage::disk('s3')->url($path);

//        if ($request->hasFile('image')) {
//            $file = $request->file('image');
//            $name = time() . $file->getClientOriginalName();
//            $filePath = 'images/' . $name;
//            Storage::disk('s3')->put($filePath, file_get_contents($file));
//        }

        $product = new Product();
//        if ($data['cat_id']){
//            $product->cat_id = $data['cat_id'];
//        }
//        if ($data['sub_cat_id']){
//            $product->sub_cat_id = $data['sub_cat_id'];
//        }
//        if ($data['brand_id']){
//            $product->brand_id = $data['brand_id'];
//        }
        if(auth('supplier')->user()){
            $product->vendor_id = auth('supplier')->user()->id;
        }else{
            $product->vendor_id = 0;
        }

        if ($data['name']){
            $product->name = $data['name'];
            $product->slug = str_replace(' ', '-', strtolower($data['name']));
        }
        if ($data['qty']){
            $product->qty = $data['qty'];
        }
        if ($data['regular_price']){
            $product->regular_price = $data['regular_price'];
        }
//        if ($data['buy_price']){
//            $product->buy_price = $data['buy_price'];
//        }
        if ($data['discount_price']){
            $product->discount_price = $data['discount_price'];
        }
        if ($data['sku']){
            $product->sku  = $data['sku'];
        }
//        if ($data['stock']){
//            $product->stock  = $data['stock'];
//        }
        if ($data['short_description']){
            $product->short_description  = $data['short_description'];
        }
        if ($data['long_description']){
            $product->long_description  = $data['long_description'];
        }
//        if ($data['vat_tax']){
//            $product->vat_tax  = $data['vat_tax'];
//        }
        if ($data['product_type']){
            $product->product_type  = $data['product_type'];
        }
        if ($data['image']){
            $product->image = $data['image'];
        }
//        if ($data['product_address']){
//            $product->product_address  = $data['product_address'];
//        }

//        $product->inside_dhaka  = $data['inside_dhaka'];
//        $product->outside_dhaka  = $data['outside_dhaka'];
//        $product->delivery_time  = $data['delivery_time'];
//        $product->seo_title  = $data['seo_title'];
//        $product->seo_description  = $data['seo_description'];
//        $product->seo_keyword  = $data['seo_keyword'];
        $product->save();

        //Product gallery image
        if(!empty($product)){

            if($data['gallery_image']){
                $imageGallery = $data['gallery_image'];
                foreach($imageGallery as $image){
//                    $name = $image->getClientOriginalName();
                    $galleryImageName = rand(10,100).'.'.$image->extension();
//                    $path = Storage::disk('s3')->put('images', $data['gallery_image']);
//                    $path = Storage::disk('s3')->url($path);
                    $imgGallery = Image::make($image->path());
                    $imgGallery->resize(240, 240, function ($const) {
                        $const->aspectRatio();
                    })->save(public_path('/galleryImage'). '/'. $galleryImageName);

//                    $galleryImageName = 'gallery'. time().'.'.$image->extension();
//                    $gallery_file = $data['gallery_image'];
//                    $filePathGalleryImage = '/assets';
//                    $gallery_path = $gallery_file->storeAs($filePathGalleryImage, $galleryImageName, 's3');
//                    Storage::disk('s3')->setVisibility($gallery_path, 'public');
//                    $image->move(public_path('/product/galleryImage'). $name);
//                    $data[] = $galleryImageName;

                    $productGalleryImage = new ProductImage();
                    $productGalleryImage->product_id = $product->id;
                    $productGalleryImage->gallery_image = $galleryImageName;
                    $productGalleryImage->save();
                }
            }

//            foreach($data['color'] as $key => $color){
//                $productColor = new ProductColor();
//                $productColor->product_id = $product->id;
//                $productColor->color = $data['color'][$key];
//                $productColor->save();
//            }
//
//            foreach($data['size'] as $key => $size){
//                $productSize = new ProductSize();
//                $productSize->product_id = $product->id;
//                $productSize->size = $data['size'][$key];
//                $productSize->save();
//            }
        }
    }

    public function edit($id)
    {
        return Product::find($id);
    }

    public function update($id, $data = [])
    {

        $productUpdate = Product::find($id);
        $image = $productUpdate['image'];
        if (isset($image)){
            $newImage = $data['image'];
            if ($data['image']){
                file_exists(('product/images/').$productUpdate['image']);
            }
            $updateImage = time().'.'. $newImage->extension();
//            $fileUpdate = $data['image'];
            $filePath = 'product/images';
//            $path = $fileUpdate->storeAs($filePath, $updateImage, 's3');
//            Storage::disk('s3')->setVisibility($path, 'public');


            //dd($filePath.'/'.$updateImage);

            $img = Image::make($newImage->path());

            $img->resize(240, 240)->save($filePath.'/240x240-'.$updateImage);
            $img->resize(null, null)->save($filePath.'/540x540-'.$updateImage);
             $img->resize(240, 240, function ($const) {
                 $const->aspectRatio();
             })->save($filePath.'/240x240-'.$updateImage);

             $img->resize(540, 500, function ($const) {
                 $const->aspectRatio();
             })->save($filePath.'/800x800-'.$updateImage);

//            $productUpdate['image'] = Storage::disk('s3')->url($path);
        }


//        $productUpdate->cat_id = $data['cat_id'];
//        $productUpdate->sub_cat_id = $data['sub_cat_id'];
//        $productUpdate->brand_id = $data['brand_id'];
        if(auth('supplier')->user()){
            $productUpdate->vendor_id = auth('supplier')->user()->id;
        }else{
            $productUpdate->vendor_id = 0;
        }
        $productUpdate->name = $data['name'];
        $productUpdate->slug = str_replace(' ', '-', strtolower($data['name']));
        $productUpdate->qty = $data['qty'];
        $productUpdate->regular_price = $data['regular_price'];
//        $productUpdate->buy_price = $data['buy_price'];
        $productUpdate->discount_price = $data['discount_price'];
        $productUpdate->sku  = $data['sku'];
//        $productUpdate->stock  = $data['stock'];
        $productUpdate->short_description  = $data['short_description'];
        $productUpdate->long_description  = $data['long_description'];
//        $productUpdate->vat_tax  = $data['vat_tax'];
        $productUpdate->product_type  = $data['product_type'];
//        $productUpdate->product_address  = $data['product_address'];
//        $productUpdate->inside_dhaka  = $data['inside_dhaka'];
//        $productUpdate->outside_dhaka  = $data['outside_dhaka'];
//        $productUpdate->delivery_time  = $data['delivery_time'];
//        $productUpdate->seo_title  = $data['seo_title'];
//        $productUpdate->seo_description  = $data['seo_description'];
//        $productUpdate->seo_keyword  = $data['seo_keyword'];
        $productUpdate->save();

        //Product gallery image
        if(!empty($productUpdate)){

            if(isset($data['gallery_image'])){
                if($data['gallery_image']){
                    ProductImage::where('product_id', $id)->delete();
                    foreach($data['gallery_image'] as $image){
                        $name = time().'.'. $image->extension();
                        $imgGallery = Image::make($image->path());
                        $imgGallery->resize(340, 340, function ($const) {
                            $const->aspectRatio();
                        })->save(public_path('/galleryImage'). '/'. $name);
//                    $image->move(public_path('/product/galleryImage'). $name);
                        $data[] = $name;

                        $productGalleryImage = new ProductImage();
                        $productGalleryImage->product_id = $productUpdate->id;
                        $productGalleryImage->gallery_image = $name;
                        $productGalleryImage->save();
                    }
                }
            }

            // foreach($data['color'] as $key => $color){
            //     $productColor = new ProductColor();
            //     $productColor->product_id = $product->id;
            //     $productColor->color = $data['color'][$key];
            //     $productColor->save();
            // }

            // foreach($data['size'] as $key => $size){
            //     $productSize = new ProductSize();
            //     $productSize->product_id = $product->id;
            //     $productSize->size = $data['size'][$key];
            //     $productSize->save();
            // }
        }
    }

    public function active($id)
    {
        $productActive = Product::find($id);
        $productActive->status = 0;
        $productActive->save();
    }

    public function inactive($id)
    {
        $productInactive = Product::find($id);
        $productInactive->status = 1;
        $productInactive->save();
    }

    public function delete($id)
    {
        $productDelete = Product::find($id);
        $productGallery = ProductImage::where('product_id', $productDelete->id)->get();
        foreach ($productGallery as $gallery){
            $gallery->delete();
        }
        $productDelete->delete();
    }
}
