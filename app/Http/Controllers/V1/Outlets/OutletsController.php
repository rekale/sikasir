<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\V1\Transformer\OutletReportTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\BestReportTransformer;

class OutletsController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-outlet');
        
        $owner = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $outlets = $this->repo()->getPaginatedForOwner($owner, $with);
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($outlets, new OutletTransformer);
    }

    public function show($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $owner = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($id);
        
        $outlet = $this->repo()->findForOwner($decodedId, $owner, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withItem($outlet, new OutletTransformer);
    }

    public function store(OutletRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-outlet');
        
        $owner = $currentUser->getCompanyId();
        
        $dataInput = $request->all();
        
        $dataInput['business_field_id'] = $this->decode($dataInput['business_field_id']);
        
        $dataInput['tax_id'] = $this->decode($dataInput['tax_id']);
        
        $this->repo()->saveForOwner($dataInput, $owner);

        return $this->response()->created();
    }

    public function update($id, OutletRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-outlet');
        
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['business_field_id'] = $this->decode($dataInput['business_field_id']);

        $dataInput['tax_id'] = $this->decode($dataInput['tax_id']);
        
        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-outlet');
        
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyForOwner($decodedId, $owner);

        return $this->response()->deleted();
    }
    
    public function best($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getTheBestForCompany($companyId, $dateRange);
     
        return $this->response()
                ->resource()
                ->withPaginated($collection, new BestReportTransformer);
    }
    
    public function profit($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $product = $this->repo()->getProfitForCompany($companyId, $dateRange);
        
        return $product;

    }
    
    public function profitForOutlet($outletId, $dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $product = $this->repo()->getProfitForCompany($companyId, $dateRange, $this->decode($outletId));
        
        return $product;

    }
    
    public function reports($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        // include it with best product or not?
        $withBestProduct = ! empty($with) && $with === 'best_products';
        
        $reports = $this->repo()->getTransactionReports($companyId, $dateRange, $withBestProduct);
        
        return $this->response()
                ->resource()
                ->including($with)
                ->withCollection($reports, new OutletReportTransformer);
    }
}
