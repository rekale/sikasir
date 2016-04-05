<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;

class CreateUserCommand extends CreateCommand 
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
				
			$user = $this->factory->create($this->data);
				
			$this->authorizer->giveAccess($this->data['privileges']);
			
			$outletIds = Obfuscater::decode($this->data['outlet_id']);
			
			$user->outlets()->attach($outletIds);
			
		});
	}
}