<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\StockTransformer;

class StocksController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }

    public function index($outletId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-inventory');
       
        $owner = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $stocks = $this->repo()
                    ->getStocksPaginated($this->decode($outletId), $owner, $with);
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($stocks, new StockTransformer);
    }

}
