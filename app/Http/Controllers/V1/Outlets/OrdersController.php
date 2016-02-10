<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OrderTransformer;
use Sikasir\V1\Repositories\OrderRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\OrderRequest;

class OrdersController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, OrderRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
   
   public function all()
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getNovoidAndDebtPaginated(
            $this->decode($outletId), $companyId, $dateRange, $with
        );
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
   }
    
   public function index($outletId, $dateRange)
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-specific-outlet');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getNovoidAndDebtPaginated(
            $this->decode($outletId), $companyId, $dateRange, $with
        );
        
        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($collection, new OrderTransformer);
   }
   
   public function void($outletId, $dateRange)
   {
        
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getVoidPaginated(
            $this->decode($outletId), $companyId, $dateRange, $with
        );

        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($collection, new OrderTransformer);
        
   }
   
    public function debt($outletId, $dateRange)
    {
        $currentUser = $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->authorizing($currentUser, 'read-order');

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getDebtPaginated(
            $this->decode($outletId), $companyId, $dateRange, $with
        );

        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($collection, new OrderTransformer);

    }
    
    public function store($outletId, OrderRequest $request)
    {
        $currentUser = $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');        
        
        $dataInput = $request->all();
        
        if ( isset($dataInput['customer_id']) ) {
            $dataInput['customer_id'] = $this->decode($dataInput['customer_id']);
        }
        
        if ( isset($dataInput['discount_id']) ) {
            $dataInput['discount_id'] = $this->decode($dataInput['discount_id']);
        }
        
        $dataInput['outlet_id'] = $this->decode($outletId);
        
        $dataInput['operator_id'] = $this->decode($dataInput['operator_id']);
        
        $dataInput['tax_id'] = $this->decode($dataInput['tax_id']);
        
        $dataInput['payment_id'] = $this->decode($dataInput['payment_id']);
        
        foreach ($dataInput['variants'] as &$variant) {
            $variant['id'] = $this->decode($variant['id']);
        }
        
        $this->repo()->save($dataInput);

        return $this->response()->created();
    }

}
