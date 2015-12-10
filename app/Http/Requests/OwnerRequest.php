<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;
use Tymon\JWTAuth\JWTAuth;

class OwnerRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(JWTAuth $auth)
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
                'email' => 'required|email|unique:users',
                'business_name' => 'required|max:255',
                'phone' => 'required|max:255',
                'address' => 'required|max:255',
                'icon' => 'max:255',
                'active' => 'required|boolean',
                'password' => 'required|max:255',
            ];
        }
        else {
            return [
                'name' => 'max:255',
                'business_name' => 'max:255',
                'email' => 'email|max:255',
                'phone' => 'max:255',
                'address' => 'max:255',
                'icon' => 'max:255',
                'password' => 'max:255', 
                'active' => 'boolean',
            ];
        }

    }
}
