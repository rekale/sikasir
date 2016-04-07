<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OrderTransformer;
use Sikasir\V1\Repositories\OrderRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\OrderRequest;
use Sikasir\V1\Orders\Order;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Reports\OrderReport;
use Illuminate\Http\Request;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\CreateOrderCommand;

class OrdersController extends TempApiController
{
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-order';
		$this->storeAccess = 'edit-order';
		$this->reportAccess = 'report-order';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Order, $this->auth->getCompanyId(), 'outlets', $throughId
		);
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType($throughId));
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType($throughId));
	}
	
	public function createCommand($throughId = null)
	{
		return new CreateOrderCommand($this->getFactory($throughId));
	}
	
	public function updateCommand($throughId = null)
	{
		throw new \Exception('not implemented');
	}
	public function getSpecificRequest()
	{
		return app(OrderRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new OrderTransformer;
	}
	
	public function getReportTransformer()
	{
		return new OrderTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		$report = new OrderReport($this->getQueryType($throughId));
		
		return $report->isNotVoid()->dontHaveDebt();
	}
	
	public function void($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    	
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
    							->report(
    								$dateRange, 
    								$report->isVoid(),
    								$this->getReportTransformer()
    							);
    }
    
    public function voidThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	
    	$report = new OrderReport($this->getQueryType($throughId));
    	
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
						    	->report(
						   			$dateRange,
						    		$report->isVoid(),
						   			$this->getReportTransformer()
						    	);
    }
    
    public function debt($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    	 
    	return $this->mediator->checkPermission($this->reportAccess)
					    	->setRequest($request)
					    	->setWith()
					    	->setPerPage()
					    	->orderBy()
					    	->report(
					   			$dateRange,
					   			$report->isNotVoid()->haveDebt(),
					    		$this->getReportTransformer()
					    	);
    }
    
    public function debtThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    	 
    	$report = new OrderReport($this->getQueryType($throughId));
    
    	return $this->mediator->checkPermission($this->reportAccess)
						    	->setRequest($request)
						    	->setWith()
						    	->setPerPage()
						    	->orderBy()
						    	->report(
						    			$dateRange,
						    			$report->isNotVoid()->haveDebtAndNotSettled(),
						    			$this->getReportTransformer()
						    	);
    }
    
    public function settled($dateRange, Request $request)
    {
    	$report = new OrderReport($this->getQueryType());
    
    	return $this->mediator->checkPermission($this->reportAccess)
					    	->setRequest($request)
					    	->setWith()
					    	->setPerPage()
					    	->orderBy()
					    	->report(
					   			$dateRange,
					   			$report->isNotVoid()->haveDebtAndSettled(),
					   			$this->getReportTransformer()
					   		);
    }
    
    public function settledThrough($throughId, $dateRange, Request $request)
    {
    	$throughId = Obfuscater::decode($throughId);
    
    	$report = new OrderReport($this->getQueryType($throughId));
    
    	return $this->mediator->checkPermission($this->reportAccess)
    	->setRequest($request)
    	->setWith()
    	->setPerPage()
    	->orderBy()
    	->report(
    			$dateRange,
    			$report->isNotVoid()->haveDebtAndSettled(),
    			$this->getReportTransformer()
    			);
    }
	
	/*
   protected $repo;
    
    public function __construct(ApiRespond $respond, OrderRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
   
   public function all($dateRange)
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
        
        $companyId = $currentUser->getCompanyId();
       
        $arrayDateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getNovoidAndDebtPaginated(
            null, $companyId, $arrayDateRange, $with
        );
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
   }
    
   public function index($outletId, $dateRange)
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
        
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
   
    public function debtNotSettled($outletId, $dateRange)
    {
        $currentUser = $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->authorizing($currentUser, 'read-order');

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getDebtPaginated(
            $this->decode($outletId), $companyId, $dateRange, false, $with
        );

        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($collection, new OrderTransformer);

    }
    
    public function debtSettled($outletId, $dateRange)
    {
        $currentUser = $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->authorizing($currentUser, 'read-order');

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $collection = $this->repo()->getDebtPaginated(
            $this->decode($outletId), $companyId, $dateRange, true, $with
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
	*/
}
