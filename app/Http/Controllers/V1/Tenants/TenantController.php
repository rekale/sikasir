<?php

namespace Sikasir\Http\Controllers\V1\Tenants;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\CompanyTransformer;
use Illuminate\Http\Request;
use Sikasir\V1\Commands\CreateUserCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\Company;
use Sikasir\V1\Repositories\NoCompany;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Transformer\BusinessFieldTransformer;
use Sikasir\V1\Reports\CustomerReport;

class TenantController extends ApiController
{
    
	public function initializeAccess()
	{
		$this->indexAccess = 'read-employee';
	}
	
	public function myCompany(Request $request)
	{
		$companyId = Obfuscater::encode($this->auth->getCompanyId());
		
		return $this->mediator->checkPermission($this->indexAccess)
					    		->setRequest($request)
    							->setWith()
    							->show(
					    			$companyId,
					    			$this->getRepository(),
					    			$this->getTransformer()
				    			);
	}
	
	public function businessField()
	{
		return( new ApiRespond)->resource()->withCollection(BusinessField::all(), new BusinessFieldTransformer);
	}
	
	public function getQueryType($throughId = null)
	{
		return  new NoCompany(new Company, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new EloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
	
		return new EloquentFactory($this->getQueryType());
	}
	
	public function createCommand($throughId = null)
	{
		return new CreateUserCommand($this->getFactory());
	}
	
	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	
	public function getSpecificRequest()
	{
		return app(Request::class);
	}
	
	
	public function getTransformer()
	{
		return new CompanyTransformer;
	}
	
	public function getReportTransformer()
	{
		return new CompanyTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		return new CustomerReport($this->getQueryType());
	}
	
  

    
}
