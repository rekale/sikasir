<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\Http\Requests\EmployeeRequest;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\User;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Commands\CreateUserCommand;
use Sikasir\V1\Commands\UpdateUserCommand;
use Sikasir\V1\Reports\EmployeeReport;
use Illuminate\Http\Request;
use Sikasir\V1\Transformer\EmployeeSellReportTransformer;

class EmployeesController extends ApiController
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
		return new EloquentRepository($this->getQueryType());
	}

	public function getFactory($throughId = null)
	{

		return new EloquentFactory($this->getQueryType($throughId));
	}

	public function createCommand($throughId = null)
	{
		$command = new CreateUserCommand($this->getFactory($throughId));

		return $command;
	}

	public function updateCommand($throughId = null)
	{
		$command = new UpdateUserCommand($this->getRepository($throughId));

		return $command;
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

	public function reportFor($id, $dateRange, Request $request)
	{
		return $this->mediator->checkPermission($this->reportAccess)
		->setRequest($request)
		->setWith()
		->reportFor(
			$id,
			$dateRange,
			$this->getReport(),
			new UserTransformer
		);
	}

	public function salesReport($dateRange, Request $request)
	{
		$result = $this->getReport()->whenDate($dateRange)->getSales();

		return $this->mediator->checkPermission($this->reportAccess)
		->setRequest($request)
		->setWith()
		->setPerPage()
		->paginatedResult($result, new EmployeeSellReportTransformer);
	}

}
