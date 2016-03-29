<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;

class TaxesController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-tax';
		$this->showAccess = 'read-tax';
		$this->destroyAccess = 'delete-tax';
	
		$this->storeAccess = 'create-tax';
		$this->updateAccess = 'update-tax';
		$this->reportAccess = 'read-tax';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Tax, $this->auth->getCompanyId());
	}
	
	public function getRepository()
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Tax, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function createCommand()
	{
		$factory =  new EloquentFactory($this->getQueryType());
		
		return new GeneralCreateCommand($factory);
	}
	
	public function updateCommand()
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	public function getSpecificRequest()
	{
		return app(TaxDiscountRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new TaxTransformer;
	}
	
	public function getReportTransformer()
	{
		return new TaxTransformer;
	}
	
	
	public function getReport()
	{
		return new CustomerReport($this->getQueryType());
	}

}
