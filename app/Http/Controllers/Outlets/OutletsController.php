<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlets\OutletRepository;
use Sikasir\Transformer\OutletTransformer;

class OutletsController extends ApiController
{
    protected $repo;
    
    public function __construct(\Sikasir\Traits\ApiRespond $respond, OutletRepository $repo) {
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
