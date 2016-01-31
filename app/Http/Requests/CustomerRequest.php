<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class CustomerRequest extends Request
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
            'name' => 'required|max:255', 
            'email' => 'required|max:255|unique:customers', 
            'sex' => 'required', 
            'phone' => 'required|max:255', 
            'address' => 'required|max:2000', 
            'city' => 'required|max:255', 
            'pos_code' => 'required|max:255',
        ];
    }
}
