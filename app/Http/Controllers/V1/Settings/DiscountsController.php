<?php

namespace Sikasir\Http\Controllers\V1\Settings;


use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Outlets\Discount;

class DiscountsController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-discount';
		$this->showAccess = 'read-discount';
		$this->destroyAccess = 'delete-discount';
	
		$this->storeAccess = 'create-discount';
		$this->updateAccess = 'update-discount';
		$this->reportAccess = 'read-discount';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Discount, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
		$queryType = new EloquentCompany(new Discount, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function createCommand($throughId = null)
	{
		$factory =  new EloquentFactory($this->getQueryType());
		
		return new GeneralCreateCommand($factory);
	}
	
	public function updateCommand($throughId = null)
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
	
	
	public function getReport($throughId = null)
	{
		return new CustomerReport($this->getQueryType());
	}
   
}
