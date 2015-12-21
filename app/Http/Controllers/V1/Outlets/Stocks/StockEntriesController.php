<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\StockEntryTransformer;
use Sikasir\Http\Requests\StockInOutRequest;

class StockEntriesController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $this->authorizing('read-stock-entry');
        
        $owner = $this->currentUser()->toOwner();
        
        $stocks = $this->repo()->getStockEntriesPaginated($this->decode($outletId), $owner);

        return $this->response()
                ->resource()
                ->withPaginated($stocks, new StockEntryTransformer);
    }
  
}
