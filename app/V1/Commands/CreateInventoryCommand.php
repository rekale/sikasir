<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;

class CreateInventoryCommand extends CreateCommand 
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
			
			$inventory = $this->factory->create($this->data);
			
			foreach ($this->data['variants'] as $variant) {
				
				$inventory->variants()->attach(
						$variant['id'], ['total' => $variant['total']]
				);
				
			}
			
		});
	}
}