<?php

namespace App\Repository\Product;

use App\Models\PageProduct;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Repository\Interface\PageProductInterface;
use App\Uploader\FileUpload;
use Illuminate\Support\Facades\Storage;
use Session;
use Intervention\Image\Facades\Image;
class PageProductRepository implements PageProductInterface
{
    public function getAllData()
    {
        return PageProduct::with('category', 'subcategory', 'brand', 'productImages')->paginate(10);
    }

    public function edit($id)
    {
        return PageProduct::find($id);
    }

    public function update($id, $data = [])
    {

        $productUpdate = PageProduct::find($id);
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
        $productActive = PageProduct::find($id);
        $productActive->status = 0;
        $productActive->save();
    }

    public function inactive($id)
    {
        $productInactive = PageProduct::find($id);
        $productInactive->status = 1;
        $productInactive->save();
    }

    public function delete($id)
    {
        $productDelete = PageProduct::find($id);
        $productGallery = ProductImage::where('product_id', $productDelete->id)->get();
        foreach ($productGallery as $gallery){
            $gallery->delete();
        }
        $productDelete->delete();
    }
}
