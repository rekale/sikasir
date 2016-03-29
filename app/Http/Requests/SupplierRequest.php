<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class SupplierRequest extends Request
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
        $rules = [
            'name' => 'required|max:255',
            'email' => 'max:255|email|unique:suppliers',
            'phone' => 'required',
            'address' => 'required|max:1000',
        ];
        
        if ($this->getMethod() === 'POST') {
        	$rules['email'] = $rules['email'] . '|required';
        }
        
        return $rules;
    }
}
