<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\StockOutTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class StockOutsController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $this->authorizing('read-stock-out');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $outlets = $this->repo()->getStockOutsPaginated($this->decode($outletId), $owner);

        return $this->response()
                ->resource()
                ->withPaginated($outlets, new StockOutTransformer);
    }

    
}
