<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\V1\Repositories\UserRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class EmployeesController extends ApiController
{
    public function __construct(ApiRespond $respond, UserRepository $repo, JWTAuth $auth) {

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
                   ->withPaginated($products, new UserTransformer);
   }
   
   public function allReports($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-staff');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getReportsForCompany(
            $companyId, $dateRange
        );
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withPaginated($collection, new UserTransformer);
    }
    
    public function reports($outletId, $dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-staff');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getReportsForCompany(
            $companyId, $dateRange, $this->decode($outletId)
        );
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withPaginated($collection, new UserTransformer);
    }
   
}
