<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\CategoryTransformer;
use Sikasir\Http\Requests\CategoryRequest;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Reports\CategoryReport;
use Sikasir\V1\Factories\EloquentFactory;

class CategoriesController extends ApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-product';
		$this->showAccess = 'read-product';
		$this->destroyAccess = 'edit-product';
	
		$this->storeAccess = 'edit-product';
		$this->updateAccess = 'edit-product';
		$this->reportAccess = 'read-report';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Category, $this->auth->getCompanyId());
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
		return new GeneralCreateCommand($this->getFactory($throughId));
	}
	
	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository());
	}
	public function getSpecificRequest()
	{
		return app(CategoryRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new CategoryTransformer;
	}
	
	public function getReportTransformer()
	{
		return new CategoryTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		$report = new CategoryReport($this->getQueryType());
		
		return $report->forOutlet($throughId);
	}
}
