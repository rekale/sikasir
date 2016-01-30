<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\Inventories\EntryRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\InventoryTransformer;
use Sikasir\Http\Requests\StockInOutRequest;

class EntriesController extends ApiController
{

    public function __construct(ApiRespond $respond, EntryRepository $repo, JWTAuth $auth) {
        
        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-inventory');
        
        $ownerId = $currentUser->getOwnerId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($outletId);
        
        $stocks = $this->repo()->getPaginatedForOwnerThrough('outlets', $ownerId, $decodedId, $with);

        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($stocks, new InventoryTransformer);
    }
  
}
