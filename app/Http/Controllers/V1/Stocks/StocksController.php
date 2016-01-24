<?php

namespace Sikasir\Http\Controllers\V1\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\ItemRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\ItemTransformer;

class StocksController extends ApiController
{

    public function __construct(ApiRespond $respond, ItemRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

     public function index($outletId)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-stock');
       
        $owner = $currentUser->getOwnerId();
        
        $stocks = $this->repo()->getStocksPaginated($this->decode($outletId), $owner);

        return $this->response()
                ->resource()
                ->withPaginated($stocks, new ItemTransformer);
    }

}
