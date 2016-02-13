<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\PaymentRequest;
use Sikasir\V1\Repositories\Settings\PaymentRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\PaymentTransformer;

class PaymentsController extends ApiController
{
    
    public function __construct(ApiRespond $respond, PaymentRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }
    
    public function allReports($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getReportsForCompany($companyId, $dateRange);
       
       return $this->response()
                   ->resource()
                   ->withPaginated($collection, new PaymentTransformer);
    }
    
     public function reports($outletId, $dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getReportsForCompany(
            $companyId, $dateRange, $this->decode($outletId)    
        );
       
       return $this->response()
                   ->resource()
                   ->withPaginated($collection, new PaymentTransformer);
    }
    
}
