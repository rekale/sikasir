<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;

class OutletsController extends ApiController
{
    protected $repo;
    
    public function __construct(\League\Fractal\Manager $fractal, OutletRepository $repo) {
        parent::__construct($fractal);
        
        $this->repo = $repo;
    }
}
