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
			
			
			$this->data['outlet_ids'] = Obfuscater::decode($this->data['outlet_ids']);

			$this->data['company_id'] = $this->auth->getCompanyId();
			
			foreach ($this->data['outlet_ids'] as $outletId) {
				
				//attach product to each outlets and save variants
				
				
				$this->data['outlet_id'] = $outletId;
					
				$product = Product::create($this->data);
				
				//create variant Models
				foreach($this->data['variants'] as $variant){
				
					$product->variants()->create($variant);
				}
				
			}
			
		});
	}
}