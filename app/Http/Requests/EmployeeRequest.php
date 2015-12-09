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
        if($this->getMethod() === 'POST') {
            return [
                'name' => 'required|max:255',
                'gender' => 'required|max:255',
                'email' => 'required|email|max:255',
                'address' => 'max:255',
                'phone'=> 'max:255',
                'void_access' => 'required|boolean',
                'password' => 'required|max:255',
                'outlet_id.0' => 'required',
            ];
        }
        else {
            return [
                'name' => 'max:255',
                'gender' => 'max:255',
                'email' => 'email|max:255',
                'address' => 'max:255',
                'phone'=> 'max:255',
                'void_access' => 'boolean',
                'password' => 'max:255',
                'outlet_id.0' => 'required',
            ];
        }
    }
}
