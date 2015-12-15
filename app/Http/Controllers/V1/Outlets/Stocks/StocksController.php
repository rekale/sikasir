<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class StocksController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $this->authorizing('read-outlet');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $outlets = $this->repo()->getPaginatedForOwner($owner);

        return $this->response()
                ->resource()
                ->withPaginated($outlets, new OutletTransformer);
    }

}
