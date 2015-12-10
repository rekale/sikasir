<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\EmployeeTransformer;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class EmployeesController extends ApiController
{
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $id
     */
   public function index($id)
   {    
       
       $decodedId = $this->decode($id);
       
       $products = $this->repo()->getEmployees($decodedId);
       
       return $this->response()
               ->resource()
               ->withPaginated($products, new EmployeeTransformer);
       
   }

}
