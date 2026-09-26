<?php

namespace App\Repository\Subcategory;

use App\Models\Subcategory;
use App\Repository\Interface\SubcategoryInterface;

class SubcategoryRepository implements SubcategoryInterface
{
    public function getAllData()
    {
        return Subcategory::with('category')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function storeOrUpdate($id = null, $data = [])
    {
        if(is_null($id)){
            $subcategory = new Subcategory();
            $subcategory->name = $data['name'];
            $subcategory->cat_id = $data['cat_id'];
            $subcategory->slug = str_replace(' ', '-', strtolower($data['name']));
            $subcategory->save();
        }else {
            $subcategory = Subcategory::find($id);
            $subcategory->name = $data['name'];
            $subcategory->cat_id = $data['cat_id'];
            $subcategory->slug = str_replace(' ', '-', strtolower($data['name']));
            $subcategory->save();
        }
    }

    public function edit($id)
    {
        return Subcategory::with('category')->find($id);
    }

    public function active($id)
    {
        $active = Subcategory::find($id);
        $active->status = 0;
        $active->save();
        return $active;
    }

    public function inactive($id)
    {
        $inactive = Subcategory::find($id);
        $inactive->status = 1;
        $inactive->save();
        return $inactive;
    }

    public function delete($id)
    {
        return Subcategory::find($id)->delete();
    }
}
