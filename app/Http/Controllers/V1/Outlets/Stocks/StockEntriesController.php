<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\StockDetailTransformer;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class StockEntriesController extends ApiController
{
    
    private $outletRepo;
    
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $this->authorizing('read-stock');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $outlets = $this->repo()
                ->findForOwner($outletId)
                ->stockDetails()
                ->paginate();

        return $this->response()
                ->resource()
                ->withPaginated($outlets, new StockDetailTransformer);
    }

}
