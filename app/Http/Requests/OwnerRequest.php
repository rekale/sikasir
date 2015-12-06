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
        return [
            'full_name' => 'required|max:255', 
            'business_name' => 'required|max:255', 
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'icon' => 'max:255', 
            'active' => 'required|boolean',
        ];
    }
}
