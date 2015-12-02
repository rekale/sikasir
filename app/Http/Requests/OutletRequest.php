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
            'code' => 'required|max:255',
            'address' => 'required|max:1000', 
            'province' => 'required|max:255', 
            'city' => 'required|max:255', 
            'pos_code' => 'required|max:255',
            'phone1' => 'required|max:255', 
            'phone2' => 'required|max:255', 
        ];
    }
}
