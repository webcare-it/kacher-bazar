<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropshippingProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'b_product_id'      => 'required|unique:products,b_product_id',
            'name'              => 'required',
            'cat_id'            => 'required|integer',
            'qty'               => 'required|integer',
            'regular_price'     => 'required',
            'product_type'      => 'required',
            'long_description'  => 'required',
            'image'             => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
            'gallery_image'     => 'required',
        ];
    }
}
