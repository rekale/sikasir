<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\BestReportTransformer;
use Sikasir\V1\Repositories\CategoryRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\ProductRequest;
use Sikasir\V1\Transformer\CategoryTransformer;

class CategoriesController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, CategoryRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    public function reports($outletId, $dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-report');
       
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
               ->withPaginated($collection, new CategoryTransformer);
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
               ->withPaginated($collection, new CategoryTransformer);
    }
     
}
