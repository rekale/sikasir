<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\Settings\TaxRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\TaxTransformer;

class TaxesController extends ApiController
{
    
    public function __construct(ApiRespond $respond, TaxRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }
    
   public function allReports($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-report');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getReportsForCompany($companyId, $dateRange);
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withPaginated($collection, new TaxTransformer);
    }
    
    public function allBestSeller($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-report');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getBestSellerForCompany($companyId, null, $dateRange);
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withPaginated($collection, new TaxTransformer);
    }
}
