<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\UpdateCommand;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;

class UpdateUserCommand extends UpdateCommand 
{
	
	private $authorizer;
	
	/**
	 * 
	 * @param Authorizer $authorizer
	 * 
	 * @return $this
	 */
	public function setAuthorizer(Authorizer $authorizer)
	{
		$this->authorizer = $authorizer;
		
		return $this;
	}
	
	public function execute() 
	{
		\DB::transaction(function () {
				
			$user = $this->repo->find($this->id);
				
			$user->update($this->data);
			
			$this->authorizer->syncAccess($this->data['privileges']);
			
			$outletIds = Obfuscater::decode($this->data['outlet_id']);
			
			$user->outlets()->sync($outletIds);
			
		});
	}
}