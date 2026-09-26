<?php

namespace App\Repository\Brand;

use App\Models\Brand;
use App\Repository\Interface\BrandInterface;

class BrandRepository implements BrandInterface
{
    public function getAllData()
    {
        return Brand::with('category', 'subcategory')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function storeOrUpdate($id = null, $data = [])
    {
        if(is_null($id)){
            $brnad = new Brand();
            $brnad->name = $data['name'];
            $brnad->cat_id = $data['cat_id'];
            $brnad->sub_cat_id = $data['sub_cat_id'];
            $brnad->slug = str_replace(' ', '-', strtolower($data['name']));
            $brnad->save();
        }else {
            $brnad = Brand::find($id);
            $brnad->name = $data['name'];
            $brnad->cat_id = $data['cat_id'];
            $brnad->sub_cat_id = $data['sub_cat_id'];
            $brnad->slug = str_replace(' ', '-', strtolower($data['name']));
            $brnad->save();
        }
    }

    public function edit($id)
    {
        return Brand::find($id);
    }

    public function active($id)
    {
        $active = Brand::find($id);
        $active->status = 0;
        $active->save();
        return $active;
    }

    public function inactive($id)
    {
        $inactive = Brand::find($id);
        $inactive->status = 1;
        $inactive->save();
        return $inactive;
    }

    public function delete($id)
    {
        return Brand::find($id)->delete();
    }
}
