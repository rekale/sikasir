<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;

class OutletsController extends ApiController
{
    protected $repo;
    
    public function __construct(\Sikasir\V1\Traits\ApiRespond $respond, OutletRepository $repo) {
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
}
