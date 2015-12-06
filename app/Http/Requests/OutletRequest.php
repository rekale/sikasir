<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class OutletRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is('owner') ? true : false;
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
            'code' => 'required|max:255',
            'business_field_id' => 'required',
            'address' => 'max:1000', 
            'province' => 'max:255', 
            'city' => 'max:255', 
            'pos_code' => 'max:255',
            'phone1' => 'max:255', 
            'phone2' => 'max:255', 
        ];
    }
}
