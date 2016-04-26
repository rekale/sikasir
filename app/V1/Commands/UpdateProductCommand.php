<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\UpdateCommand;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Variant;

class UpdateProductCommand extends UpdateCommand 
{
	
	public function execute() 
	{
		\DB::transaction(function () {
				
			$product = $this->repo->find($this->id);
				
			$product->update($this->data);
			
			foreach ( $this->data['variants'] as $variant) {
				
				$product->variants()->findOrfail($variant['id'])->update($variant);
				
			}
		});
	}
}