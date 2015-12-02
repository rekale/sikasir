<?php

namespace Sikasir\V1\Http\Controllers\Products;

use Illuminate\Http\Request;
use Sikasir\V1\Http\Controllers\ApiController;

class ProductsController extends ApiController
{
    protected $repo;
    
    public function __construct(\Sikasir\V1\Traits\ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    public function index()
    {
        
    }
}
