<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\Outlet;
use Sikasir\Transformer\ProductTransformer;
use Sikasir\Outlets\OutletRepository;


class ProductsController extends ApiController
{
   protected $repo;
    
    public function __construct(\Sikasir\Traits\ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       
       $products = $this->repo->getProducts($outletId);
       
       return $this->response->withPaginated($products, new ProductTransformer);
       
   }

}
