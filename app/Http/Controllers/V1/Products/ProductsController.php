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

class ProductsController extends TempApiController implements
													manipulatable
{
	use Storable;
	
    
    public function initializeAccess()
    {
    	$this->storeAccess = 'create-product';
    }
    
    public function getQueryType($throughId = null)
    {
    	return new EloquentThroughCompany(
    		new Product, $this->auth->getCompanyId(), 'categories', $throughId
    	);
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
