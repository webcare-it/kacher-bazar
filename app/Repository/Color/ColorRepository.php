<?php

namespace App\Repository\Color;

use App\Models\Color;
use App\Repository\Interface\ColorInterface;

class ColorRepository implements ColorInterface
{
    public function getAllData()
    {
        return Color::orderBy('created_at', 'desc')->paginate(10);
    }

    public function storeOrUpdate($id = null, $data = [])
    {
        if(is_null($id)){
            $color = new Color();
            $color->name = $data['name'];
            if($data['vendor_id']){
                $color->vendor_id = $data['vendor_id'];
            }
            $color->save();
        }else {
            $color = Color::find($id);
            $color->name = $data['name'];
            if($data['vendor_id']){
                $color->vendor_id = $data['vendor_id'];
            }
            $color->save();
        }
    }

    public function edit($id)
    {
        return Color::find($id);
    }

    public function active($id)
    {
        $active = Color::find($id);
        $active->status = 0;
        $active->save();
        return $active;
    }

    public function inactive($id)
    {
        $inactive = Color::find($id);
        $inactive->status = 1;
        $inactive->save();
        return $inactive;
    }

    public function delete($id)
    {
        return Color::find($id)->delete();
    }
}
