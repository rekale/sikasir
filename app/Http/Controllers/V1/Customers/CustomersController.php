<?php

namespace Sikasir\Http\Controllers\V1\Customers;

use Sikasir\Http\Requests\CustomerRequest;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Interfaces\CurrentUser;
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

class CustomersController extends TempApiController
{
    
	use Indexable, Showable, Storable, Updateable, Destroyable, Reportable;
	
	public function __construct(CurrentUser $user, ApiRespond $response)
	{
		parent::__construct($user, $response);
	
	}
	
	public function getRepo()
	{
		$queryType = new EloquentCompany(new Customer, $this->currentUser->getCompanyId());
	
		return new TempEloquentRepository($queryType);
	}
	
	public function getFactory()
	{
		$queryType = new EloquentCompany(new Customer, $this->currentUser->getCompanyId());
	
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

		$queryType = new EloquentCompany(new Customer, $this->currentUser->getCompanyId());
		
		return new CustomerReport($queryType);
	}
   
}
