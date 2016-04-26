<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Requests\ProductRequest;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Commands\CreateProductCommand;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\NoCompany;
use Sikasir\V1\Commands\UpdateProductCommand;

class ProductsController extends ApiController
{
	
	public function initializeAccess()
	{
		$this->indexAccess = 'read-product';
		$this->showAccess = 'read-product';
		$this->destroyAccess = 'edit-product';
	
		$this->storeAccess = 'edit-product';
		$this->updateAccess = 'edit-product';
		
	}
    
    public function getQueryType($throughId = null)
    {
    	return new EloquentThroughCompany(
    		new Product, $this->auth->getCompanyId(), 'categories', $throughId
    	);
    }
    public function getRepository($throughId = null)
    {
    	return new EloquentRepository($this->getQueryType($throughId));
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
    	$command = new UpdateProductCommand($this->getRepository($throughId));
    	
    	return $command;
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
    	throw new \Exception('not implemented');
    }
    
    public function destroyVariants($ids)
    {
    	$repo = new EloquentRepository(
    		new NoCompany(new Variant)
    	);
    	
    	    return $this->mediator->checkPermission($this->destroyAccess)
    						->destroy(
    							$ids, 
   								$repo
   							);
    }
    

}
