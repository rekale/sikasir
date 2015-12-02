<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\V1\Outlet;
use Sikasir\V1\Transformer\EmployeeTransformer;
use Sikasir\V1\Outlets\OutletRepository;


class EmployeesController extends ApiController
{
   protected $repo;
    
    public function __construct(\Sikasir\V1\Traits\ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       
       $products = $this->repo->getEmployees($outletId);
       
       return $this->response->withPaginated($products, new EmployeeTransformer);
       
   }

}
