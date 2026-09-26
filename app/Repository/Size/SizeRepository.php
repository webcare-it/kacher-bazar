<?php

namespace App\Repository\Size;

use App\Models\Size;
use App\Repository\Interface\SizeInterface;

class SizeRepository implements SizeInterface
{
    public function getAllData()
    {
        return Size::orderBy('created_at', 'desc')->paginate(10);
    }

    public function storeOrUpdate($id = null, $data = [])
    {
        if(is_null($id)){
            $size = new Size();
            $size->name = $data['name'];
            if($data['vendor_id']){
                $size->vendor_id = $data['vendor_id'];
            }
            $size->save();
        }else {
            $size = Size::find($id);
            $size->name = $data['name'];
            if($data['vendor_id']){
                $size->vendor_id = $data['vendor_id'];
            }
            $size->save();
        }
    }

    public function edit($id)
    {
        return Size::find($id);
    }

    public function active($id)
    {
        $active = Size::find($id);
        $active->status = 0;
        $active->save();
        return $active;
    }

    public function inactive($id)
    {
        $inactive = Size::find($id);
        $inactive->status = 1;
        $inactive->save();
        return $inactive;
    }

    public function delete($id)
    {
        return Size::find($id)->delete();
    }
}
