<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;

class CreateOrderCommand extends CreateCommand 
{
	
	public function execute() 
	{
		\DB::transaction(function () {
			
			$order = $this->factory->create($this->data);
			
			foreach ($this->data['variants'] as $variant) {
				
				$order->variants()->attach(
					$variant['id'],
					[
							'total' => $variant['quantity'],
							'nego' => $variant['nego'],
					]
				);
				
			}
			
		});
	}
}