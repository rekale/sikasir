<?php

namespace Sikasir\Http\Controllers\V1\Settings;


use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Outlets\Discount;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class DiscountsController extends TempApiController implements
													Resourcable,
													manipulatable
{
	use Showable, Destroyable, Updateable, Storable;
	
	public function getQueryType($throughId = null)
	{
		return new EloquentCompany(new Discount, $this->auth->getCompanyId());
	}
	
	public function getRepo()
	{
		return new TempEloquentRepository($this->getQueryType());
	}
	
	public function getFactory()
	{
		return new EloquentFactory($this->getQueryType());
	}
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-discount';
		$this->showAccess = 'read-discount';
		$this->deleteAccess = 'delete-discount';
	
		$this->storeAccess = 'create-discount';
		$this->updateAccess = 'update-discount';
	}
	
	public function getRequest()
	{
		return app(TaxDiscountRequest::class);
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
	
	public function getTransformer()
	{
		return new TaxTransformer;
	}
   
}
