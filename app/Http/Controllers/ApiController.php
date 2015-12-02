<?php

namespace Sikasir\Http\Controllers;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Traits\ApiRespond;

class ApiController extends Controller
{
    
    use IdObfuscater;
    
    /**
     *
     * @var Sikasir\V1\Traits\ApiRespond
     */
    protected $response;
    
    public function __construct(ApiRespond $respond) {
        
        $this->response = $respond;
        
    }
    
    
    
}
