<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\User\User;

class CreateOutletCommand extends CreateCommand 
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
			

			$outlet = $this->factory->create($this->data);
				
			$owner = User::whereTitle('owner')
							->whereCompanyId($this->auth->getCompanyId())
							->first();
			
			$owner->outlets()->attach($outlet->id);
			
		});
	}
}