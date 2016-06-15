<?php

namespace Sikasir\Http\Controllers\V1\Suppliers;


use Sikasir\V1\Transformer\PurchaseOrderTransformer;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Commands\CreateInventoryCommand;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Suppliers\Supplier;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Stocks\PurchaseOrder;

class POController extends ApiController
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
		return new EloquentRepository($this->getQueryType($throughId));
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
		return new GeneralUpdateCommand($this->getRepository($throughId));
	}
	public function getSpecificRequest()
	{
		throw new \Exception('not implemented');
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
