<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\V1\Transformer\InventoryTransformer;
use Sikasir\Http\Requests\InventoryRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\CreateInventoryCommand;

class OutsController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-inventory';
		$this->storeAccess = 'create-inventory';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Out, $this->auth->getCompanyId(), 'outlets', $throughId
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
		return app(InventoryRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new InventoryTransformer;
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
