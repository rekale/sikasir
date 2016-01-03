<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\OutTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class OutsController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $this->authorizing('read-stock-out');
        
        $owner = $this->auth()->toUser()->toOwner();
         
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getOutsPaginated($this->decode($outletId), $owner, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OutTransformer);
    }

    
}
