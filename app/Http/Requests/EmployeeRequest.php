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
            'title' => 'required|max:255',
            'gender' => 'required|max:255',
            'email' => 'required|email',
            'address' => 'max:255',
            'phone'=> 'max:255',
            'password' => 'required|max:255',
            'outlet_id.0' => 'required',
        ];
        
        $rules['email'] = $this->method() === 'POST'
		        		? $rules['email'] . '|unique:users'
		        		: $rules['email']
		        		;
    
        return $rules;

    }
}
