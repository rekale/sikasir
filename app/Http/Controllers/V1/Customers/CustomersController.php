<?php

namespace Sikasir\Http\Controllers\V1\Customers;

use Sikasir\Http\Requests\CustomerRequest;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\V1\Traits\Indexable;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Reports\CustomerReport;
use Sikasir\V1\Reports\Report;
use Sikasir\V1\Transformer\CustomerHistoryTransformer;
use Sikasir\Http\Controllers\V1\Traits\Reportable;
use Sikasir\Http\Controllers\V1\Interfaces\Reportable as CanReport;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class CustomersController extends TempApiController implements 
													Resourcable, 
													manipulatable,
													CanReport
{
    
	use Indexable, Showable, Storable, Updateable, Destroyable, Reportable;
	
	public function getQueryType($throughId = null) 
	{
		return  new EloquentCompany(new Customer, $this->auth->getCompanyId());
	}
	
	public function getRepo()
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Customer, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-customer';
		$this->showAccess = 'read-customer';
		$this->deleteAccess = 'delete-customer';
	
		$this->storeAccess = 'create-customer';
		$this->updateAccess = 'update-customer';
		$this->reportAccess = 'read-report';
	}
	
	public function getRequest()
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

		$queryType = new EloquentCompany(new Customer, $this->auth->getCompanyId());
		
		return new CustomerReport($queryType);
	}
	
	public function createJob(array $data)
	{
		$factory = new EloquentFactory($this->getQueryType());
		
		$factory->create($data);
	}
	

	public function updateJob($id, array $data)
	{
		$repo = $this->getRepo();
        
        $entity = $repo->find($id);
        
        $entity->update($data);
        
	}

}
