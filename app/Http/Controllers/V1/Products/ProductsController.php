<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Requests\ProductRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Commands\CreateProductCommand;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\V1\Repositories\TempEloquentRepository;

class ProductsController extends TempApiController
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
    	return new EloquentThroughCompany(
    		new Product, $this->auth->getCompanyId(), 'categories', $throughId
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
    	$command = new CreateProductCommand($this->getFactory($throughId));
    	
    	return $command->setAuth($this->auth);
    }
    
    public function updateCommand($throughId = null)
    {
    	throw new \Exception('not implemented');
    }
    public function getSpecificRequest()
    {
    	return app(ProductRequest::class);
    }
    
    
    public function getTransformer()
    {
    	return new ProductTransformer;
    }
    
    public function getReportTransformer()
    {
    	return new ProductTransformer;
    }
    
    
    public function getReport($throughId = null)
    {
    	return new CustomerReport($this->getQueryType($throughId));
    }
    
	public function createJob(array $data) 
	{
		\DB::transaction(function() use  ($data) {
			
			$factory = new EloquentFactory(
				$this->getQueryType($data['category_id'])
			);
			
			$variantModels = [];
			
			//create variant Models
			foreach($data['variants'] as $variant){
			
				$variantModels[] = new Variant($variant);
			}
			
			$data['outlet_ids'] = Obfuscater::decode($data['outlet_ids']);
				
			//attach product to each outlets and save variants
			foreach ($data['outlet_ids'] as $outletId) {
			
				$data['outlet_id'] = $outletId;
				
				$product = $factory->create($data);
				
				$product->variants()->saveMany($variantModels);
			}
			
			
				
		});	
	}

	public function updateJob($id, array $data) 
	{
		throw new \Exception("belom bisa update");
	}

	public function getRequest() 
	{
		return app(ProductRequest::class);
	}

}
