<?php

namespace Sikasir\Http\Controllers\V1\Customers;

use Sikasir\Http\Requests\CustomerRequest;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Reports\CustomerReport;
use Sikasir\V1\Reports\Report;
use Sikasir\V1\Transformer\CustomerHistoryTransformer;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;

class CustomersController extends TempApiController
{
    
	
	public function getQueryType($throughId = null) 
	{
		return  new EloquentCompany(new Customer, $this->auth->getCompanyId());
	}
	
	public function getRepository()
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Customer, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function createCommand()
	{
		$factory =  EloquentFactory($this->getQueryType());
		
		return new GeneralCreateCommand($factory);
	}
	
	public function updateCommand()
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-customer';
		$this->showAccess = 'read-customer';
		$this->destroyAccess = 'delete-customer';
	
		$this->storeAccess = 'create-customer';
		$this->updateAccess = 'update-customer';
		$this->reportAccess = 'read-report';
	}
	
	public function getSpecificRequest()
	{
		return app(CustomerRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new CustomerTransformer;
	}
	
	public function getReportTransformer()
	{
		return new CustomerHistoryTransformer;
	}
	

	public function getReport()
	{
		return new CustomerReport($this->getQueryType());
	}
	

}
