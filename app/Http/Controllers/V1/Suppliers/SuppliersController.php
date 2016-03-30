<?php

namespace Sikasir\Http\Controllers\V1\Suppliers;

use \Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Repositories\SupplierRepository;
use Sikasir\Http\Requests\SupplierRequest;
use Sikasir\V1\Transformer\SupplierTransformer;
use Sikasir\V1\Transformer\PurchaseOrderTransformer;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Suppliers\Supplier;
use Sikasir\V1\Repositories\TempEloquentRepository;

class SuppliersController extends TempApiController
{

	public function initializeAccess()
	{
		$this->indexAccess = 'read-supplier';
		$this->showAccess = 'read-supplier';
		$this->destroyAccess = 'edit-supplier';
	
		$this->storeAccess = 'edit-supplier';
		$this->updateAccess = 'edit-supplier';
		$this->reportAccess = 'edit-supplier';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Supplier, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType());
	}
	
	public function createCommand($throughId = null)
	{
		return new GeneralCreateCommand($this->getFactory());
	}
	
	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	public function getSpecificRequest()
	{
		return app(SupplierRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new SupplierTransformer;
	}
	
	public function getReportTransformer()
	{
		return new SupplierTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		return new CustomerReport($this->getQueryType());
	}
   
   public function purchaseOrders($id)
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-supplier');

        $ownerId = $currentUser->getCompanyId();

        $decodedId = $this->decode($id);
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getPurchaseOrdersForCompany($decodedId, $ownerId, $with);
        
        return $this->response()
                    ->resource()
                    ->including($with)
                    ->withPaginated($collection, new PurchaseOrderTransformer);
   }
}
