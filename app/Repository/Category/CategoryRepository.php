<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Interface\CategoryInterface;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryInterface
{
    public function getAllData()
    {
        return Category::orderBy('created_at', 'desc')->paginate(10);
    }

    public function storeOrUpdate($id = null, $data = [])
    {
        if(is_null($id)){
            if ($data['image']){
                $image = time().'.'. $data['image']->extension();
                $data['image']->move(public_path('category'), $image);
            }

            if ($data['banner']){
                $bannerImage = rand(99999, 1000000).'.'. $data['banner']->extension();
                $data['banner']->move(public_path('category'), $bannerImage);
            }

            $category = new Category();
            $category->name = $data['name'];
            $category->image = $image;
            $category->banner = $bannerImage;
            $category->slug = Str::slug($data['name']);
            $category->save();
        }else {
            $category = Category::find($id);
            if (isset($data['image'])){
                if ($data['image'] && file_exists(('category/').$category['image'])){
                    file_exists(('category/').$category['image']);
                }
                $updateImage = time().'.'. $data['image']->extension();

                $data['image']->move(public_path('category'), $updateImage);
                $category['image'] = $updateImage;
            }
            if (isset($data['banner'])){
                if ($data['banner'] && file_exists(('category/').$category['banner'])){
                    file_exists(('category/').$category['banner']);
                }
                $updateBannerImage = rand(99999, 1000000).'.'. $data['banner']->extension();

                $data['banner']->move(public_path('category'), $updateBannerImage);
                $category['banner'] = $updateBannerImage;
            }
            $category->name = $data['name'];
            $category->slug = Str::slug($data['name']);
            $category->save();
        }
    }

    public function edit($id)
    {
        return Category::find($id);
    }

    public function active($id)
    {
        $activeCategory = Category::find($id);
        $activeCategory->status = 0;
        $activeCategory->save();
        return $activeCategory;
    }

    public function inactive($id)
    {
        $inactiveCategory = Category::find($id);
        $inactiveCategory->status = 1;
        $inactiveCategory->save();
        return $inactiveCategory;
    }

    public function delete($id)
    {
        return Category::find($id)->delete();
    }
}
