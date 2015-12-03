<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class OutletsController extends ApiController
{
    protected $repo;
    
    public function __construct( ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    public function index()
    {
       $outlets = $this->repo->getPaginated();
       
       return $this->response->withPaginated($outlets, new OutletTransformer);
    }
    
    public function show($outletId)
    {
        $outlet = $this->repo->find($outletId);
        
        return $this->response->withItem($outlet, new OutletTransformer);
    }
    
    public function store(OutletRequest $request, JWTAuth $loggedUser)
    {
        $this->repo->save($request->all(), $loggedUser);
        
        return $this->response->created();
    }
}
