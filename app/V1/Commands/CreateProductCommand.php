<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;

class CreateProductCommand extends CreateCommand 
{
	private $auth;
	
	/**
	 * 
	 * @param AuthInterface $auth
	 * 
	 * @return $this
	 */
	public function setAuth(AuthInterface $auth)
	{
		$this->auth = $auth;
		
		return $this;
	}
	
	public function execute() 
	{
		\DB::transaction(function () {
			
			$variantModels = [];
			
			//create variant Models
			foreach($this->data['variants'] as $variant){
			
				$variantModels[] = new Variant($variant);
			}
			
			$this->data['outlet_ids'] = Obfuscater::decode($this->data['outlet_ids']);
			
			//attach product to each outlets and save variants
			foreach ($this->data['outlet_ids'] as $outletId) {
			
				$this->data['outlet_id'] = $outletId;
				$this->data['company_id'] = $this->auth->getCompanyId();
				
				$product = Product::create($this->data);
				
				$product->variants()->saveMany($variantModels);
			}
			
		});
	}
}