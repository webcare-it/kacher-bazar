<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            // 'first_name' => 'required|string',
            // 'last_name'  => 'required|string',
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email',
            // 'phone'      => 'required|unique:users,phone',
            'password'   => 'required|max:10|min:8|confirmed',
            // 'avatar'     => 'required|max:1024',
        ];
    }
}
