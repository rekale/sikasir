<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\EntryTransformer;
use Sikasir\Http\Requests\StockInOutRequest;

class EntriesController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $this->authorizing('read-stock-entry');
        
        $owner = $this->currentUser()->toOwner();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $stocks = $this->repo()->getEntriesPaginated($this->decode($outletId), $owner, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($stocks, new EntryTransformer);
    }
  
}
