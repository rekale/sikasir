<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;

class CreateUserCommand extends CreateCommand 
{
	
	public function execute() 
	{
		\DB::transaction(function () {
			
			$authorizer = new Authorizer();
			
			if ($this->data['title'] === 1) {
				$this->data['title'] = 'staff';
				$authorizer->managerDefault();
			}
			if ($this->data['title'] === 2) {
				$this->data['title'] = 'kasir';
				$authorizer->cashierDefault();
			}
			if ($this->data['title'] === 3) {
				$this->data['title'] = 'owner';
				$authorizer->ownerDefault();
			}
			
			$this->data['password'] = bcrypt($this->data['password']);
			
			$user = $this->factory->create($this->data);
				
			$authorizer->setUser($user)->giveAccess($this->data['privileges']);
			
			$outletIds = Obfuscater::decode($this->data['outlet_id']);
			
			$user->outlets()->attach($outletIds);
			
		});
	}
}