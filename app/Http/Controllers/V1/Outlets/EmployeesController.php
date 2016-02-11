<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\EmployeeTransformer;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class EmployeesController extends ApiController
{
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $outletId
     */
   public function index($outletId)
   {    
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();

        $this->authorizing($currentUser, 'read-staff');
        
        $decodedId = $this->decode($outletId);
       
        $products = $this->repo()->getPaginatedfromOutlet($companyId, $decodedId);
       
        return $this->response()
                   ->resource()
                   ->withPaginated($products, new EmployeeTransformer);
   }
   
   public function reports($outletId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-staff');
       
        $companyId = $currentUser->getCompanyId();
        
        $collection = $this->repo()->getReportsForCompany(
            $companyId, $this->decode($outletId)
        );
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withPaginated($collection, new ProductTransformer);
    }
   
}
