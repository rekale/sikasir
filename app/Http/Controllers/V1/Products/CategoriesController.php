<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Transformer\CategoryTransformer;
use Sikasir\Http\Requests\CategoryRequest;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;

class CategoriesController extends TempApiController
{
	public function initializeAccess()
	{
		$this->indexAccess = 'read-category';
		$this->showAccess = 'read-category';
		$this->destroyAccess = 'delete-category';
	
		$this->storeAccess = 'create-category';
		$this->updateAccess = 'update-category';
		$this->reportAccess = 'read-category';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentCompany(new Category, $this->auth->getCompanyId());
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory($throughId = null)
	{
		$queryType = new EloquentCompany(new Category, $this->auth->getCompanyId());
	
		return new EloquentFactory($queryType);
	}
	
	public function createCommand($throughId = null)
	{
		$factory =  EloquentFactory($this->getQueryType());
	
		return new GeneralCreateCommand($factory);
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
		return new CustomerReport($this->getQueryType());
	}
}
