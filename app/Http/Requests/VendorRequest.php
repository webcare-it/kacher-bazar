<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'logo' => 'required',
            'email' => 'required|email|unique:suppliers',
            'phone' => 'required',
            'shop_name' => 'required',
            'address' => 'required',
            'password' =>'required|min:8'
        ];
    }
}
