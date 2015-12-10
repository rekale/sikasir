<?php

namespace Sikasir\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Sikasir\V1\Traits\ApiRespond;

abstract class Request extends FormRequest
{
    public function response(array $errors) {
        
        $response = app(ApiRespond::class);
        
        return $response->inputNotProcessable($errors);
        
    }
}
