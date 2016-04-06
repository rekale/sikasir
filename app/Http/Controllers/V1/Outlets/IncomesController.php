<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\V1\Transformer\KasTransformer;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Finances\Income;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\Http\Requests\KasRequest;
use Sikasir\V1\Repositories\EloquentThroughCompany;

class IncomesController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-settings';
		$this->storeAccess = 'read-settings';
	
		$this->destroyAccess = 'read-settings';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Income, $this->auth->getCompanyId(), 'outlets', $throughId
		);
		
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType($throughId));
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType($throughId));
	}
	
	public function createCommand($throughId = null)
	{
		$factory =  new EloquentFactory($this->getQueryType($throughId));
	
		return new GeneralCreateCommand($factory);
	}
	
	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository($throughId));
	}
	public function getSpecificRequest()
	{
		return app(KasRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new KasTransformer;
	}
	
	public function getReportTransformer()
	{
		return new KasTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		throw new \Exception('not implemented');
	}   
}
