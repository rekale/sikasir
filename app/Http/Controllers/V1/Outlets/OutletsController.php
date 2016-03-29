<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;

class OutletsController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-outlet';
		$this->showAccess = 'read-outlet';
		$this->destroyAccess = 'delete-outlet';
	
		$this->storeAccess = 'create-outlet';
		$this->updateAccess = 'update-outlet';
		$this->reportAccess = 'read-outlet';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Outlet, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
		$queryType = new EloquentCompany(new Outlet, $this->auth->getCompanyId());
	
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
		return app(OutletRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new OutletTransformer;
	}
	
	public function getReportTransformer()
	{
		return new OutletTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		return new CustomerReport($this->getQueryType());
	}
}
