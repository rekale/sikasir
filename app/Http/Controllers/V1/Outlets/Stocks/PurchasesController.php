<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\PurchaseOrderRepository;
use Sikasir\V1\Transformer\PurchaseOrderTransformer;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class PurchasesController extends ApiController
{

    public function __construct(ApiRespond $respond, PurchaseOrderRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }

    public function index($outletId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-inventory');
       
        $ownerId = $currentUser->getOwnerId();
         
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()
                           ->getPaginatedForOwnerThrough(
                                'outlets', $ownerId, $this->decode($outletId), $with
                            );

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new PurchaseOrderTransformer);
    }

    
}
