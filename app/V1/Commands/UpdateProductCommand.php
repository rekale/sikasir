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
			
			if ( isset($this->data['variants']) ) {
				
				foreach ( $this->data['variants'] as $variant) {
					
					if (isset($variant['id'])) {
						$product->variants()->findOrFail($variant['id'])->update($variant);
					}
					else {
						$product->variants()->create($variant);
					}
				
				}	
			}
			
		});
	}
}