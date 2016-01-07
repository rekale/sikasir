<?php

namespace Sikasir\Http\Controllers\V1\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\StockRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\ItemTransformer;

class StocksController extends ApiController
{

    public function __construct(ApiRespond $respond, StockRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

     public function index($outletId)
    {
        $this->authorizing('read-stock');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $stocks = $this->repo()->getStocksPaginated($this->decode($outletId), $owner);

        return $this->response()
                ->resource()
                ->withPaginated($stocks, new ItemTransformer);
    }

}
