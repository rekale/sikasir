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
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Stocks\PurchaseOrder;

class POController extends TempApiController
{

	public function initializeAccess()
	{
		$this->indexAccess = 'read-supplier';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new PurchaseOrder, $this->auth->getCompanyId(), 'suppliers', $throughId);
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType($throughId));
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
		return new PurchaseOrderTransformer;
	}
	
	public function getReportTransformer()
	{
		return new PurchaseOrderTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		throw new \Exception('not implemented');
	}
   
}
