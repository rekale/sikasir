<?php

namespace Sikasir\Http\Controllers\Products;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;

class ProductsController extends ApiController
{
    protected $repo;
    
    public function __construct(\Sikasir\Traits\ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    public function index()
    {
        
    }
}
