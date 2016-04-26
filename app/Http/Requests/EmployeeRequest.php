<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class EmployeeRequest extends Request
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
            'title' => 'required|in:1,2,3',
            'gender' => 'required|max:255',
            'email' => 'max:255|email|unique:users',
            'address' => 'max:255',
            'phone'=> 'max:255',
            'password' => 'required|max:255',
            'outlet_id.0' => 'required',
        ];
        
        if ($this->getMethod() === 'POST') {
        	$rules['email'] = $rules['email'] . '|required';
        }
        
        return $rules;

    }
}
