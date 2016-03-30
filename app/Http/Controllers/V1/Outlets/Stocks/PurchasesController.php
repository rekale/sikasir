<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\CreateInventoryCommand;
use Sikasir\V1\Transformer\PurchaseOrderTransformer;
use Sikasir\Http\Requests\PurchaseOrderRequest;

class PurchasesController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-inventory';
		$this->storeAccess = 'edit-inventory';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new PurchaseOrder, $this->auth->getCompanyId(), 'outlets', $throughId
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
		return new CreateInventoryCommand($this->getFactory($throughId));
	}
	
	public function updateCommand($throughId = null)
	{

		throw new \Exception('not implemented');
	}
	public function getSpecificRequest()
	{
		return app(PurchaseOrderRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new PurchaseOrderTransformer;
	}
	
	public function getReportTransformer()
	{
		throw new \Exception('not implemented');
	}
	
	
	public function getReport($throughId = null)
	{
		throw new \Exception('not implemented');
	}
}
