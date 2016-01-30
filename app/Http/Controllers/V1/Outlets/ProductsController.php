<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class ProductsController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, ProductRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $outletId
     */
   public function index($outletId)
   {    
        $currentUser =  $this->currentUser();

        $this->authorizing($currentUser, 'read-product');

        $ownerId = $currentUser->getOwnerId();

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($outletId);

        $products = $this->repo()
                        ->getPaginatedForOwnerThrough(
                            'outlets', $ownerId, $decodedId, $with
                        );
        
       return $this->response()
               ->resource()
               ->including($include)
               ->withPaginated($products, new ProductTransformer);
       
   }

}
