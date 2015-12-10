<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class ProductsController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       
       $products = $this->repo()->getProducts($outletId);
       
       return $this->response()
               ->resource()
               ->withPaginated($products, new ProductTransformer);
       
   }

}
