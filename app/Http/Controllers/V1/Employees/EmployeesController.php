<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\Http\Requests\EmployeeRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\User\User;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Commands\CreateUserCommand;
use Sikasir\V1\Commands\UpdateUserCommand;
use Sikasir\V1\Reports\EmployeeReport;

class EmployeesController extends TempApiController
{
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-employee';
		$this->showAccess = 'read-employee';
		$this->destroyAccess = 'edit-employee';
	
		$this->storeAccess = 'edit-employee';
		$this->updateAccess = 'edit-employee';
		$this->reportAccess = 'read-report';
	}
	
	public function getQueryType($throughId = null) 
	{
		return  new EloquentCompany(new User, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
	
		return new EloquentFactory($this->getQueryType());
	}
	
	public function createCommand($throughId = null)
	{
		$factory =  EloquentFactory($this->getQueryType());
		
		$command = new CreateUserCommand($factory);
		
		return $command->setAuthorizer(new Authorizer($this->auth));
	}
	
	public function updateCommand($throughId = null)
	{
		$command = new UpdateUserCommand($this->getRepository());
		return $command->setAuthorizer(new Authorizer($this->auth));
	}
	
	public function getSpecificRequest()
	{
		return app(EmployeeRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new UserTransformer;
	}
	
	public function getReportTransformer()
	{
		return new UserTransformer;
	}
	

	public function getReport($throughId = null)
	{
		return new EmployeeReport($this->getQueryType());
	}

}
