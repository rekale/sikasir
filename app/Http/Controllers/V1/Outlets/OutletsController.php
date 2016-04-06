<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Commands\CreateOutletCommand;

class OutletsController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-outlet';
		$this->showAccess = 'read-outlet';
		$this->destroyAccess = 'edit-outlet';
	
		$this->storeAccess = 'edit-outlet';
		$this->updateAccess = 'edit-outlet';
		$this->reportAccess = 'read-report';
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
		return new EloquentFactory($this->getQueryType());
	}
	
	public function createCommand($throughId = null)
	{
		$factory =  new EloquentFactory($this->getQueryType());
		
		$command = new CreateOutletCommand($factory);
		
		return $command->setAuth($this->auth);
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
		throw new \Exception('not implemented');
	}
}
