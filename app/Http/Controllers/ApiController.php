<?php

namespace Sikasir\Http\Controllers;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\Controller;
use Sikasir\Traits\IdObfuscater;
use Sikasir\Traits\ApiRespond;

class ApiController extends Controller
{
    
    use IdObfuscater;
    
    /**
     *
     * @var Sikasir\Traits\ApiRespond
     */
    protected $response;
    
    public function __construct(ApiRespond $respond) {
        
        $this->response = $respond;
    
        
    }
    
    /**
     * 
     * @return Sikasir\Traits\ApiRespond
     */
    protected function response()
    {
        return $this->response;
    }
  
    
    
}
