<?php

namespace Sikasir\V1\User;


class Authorizer 
{
	/**
	 * 
	 * @var User
	 */
	private $user;
	
	/**
	 * 
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	public function checkAccess($access)
	{
		if($this->user->cant($access)) {
			abort(403);
		}
		
	}
	/**
	 * 1. do product abilities
	 * 2. do order abilties
	 * 3. do report abilities
	 * 4. do billing abilities
	 * 
	 * @param array $privileges
	 */
	public function giveAccess(array $privileges)
	{
		if (in_array( 1, $privileges)) {
			$this->user->allow($this->doProductAbilities());
		}
		if (in_array( 2, $privileges)) {
			$this->user->allow($this->doOrderAbilties());
		}
		if (in_array( 3, $privileges)) {
			$this->user->allow($this->doReportAbilties());
		}
		if (in_array( 4, $privileges)) {
			$this->user->allow($this->doBillingAbilties());
		}
	}
	
	/**
	 * add new access,and remove access that is not in array
	 * 
	 * @param array $privileges
	 */
	public function syncAccess(array $privileges)
	{
		$this->giveAccess($privileges);
		
		if (! in_array( 1, $privileges)) {
			$this->user->disallow($this->doProductAbilities());
		}
		if (! in_array( 2, $privileges)) {
			$this->user->disallow($this->doOrderAbilties());
		}
		if (! in_array( 3, $privileges)) {
			$this->user->disallow($this->doReportAbilties());
		}
		if (! in_array( 4, $privileges)) {
			$this->user->disallow($this->doBillingAbilties());
		}
	}
	
	
	
	private function doProductAbilities()
	{
		return [
				'create-product',
				'read-product',
				'update-product',
				'delete-product',
	
				'create-inventory',
				'read-inventory',
				'update-inventory',
				'delete-inventory',
		];
	}
	
	private function doOrderAbilties()
	{
		return [
				'create-order',
				'read-order',
				'void-order',
				'update-order',
		];
	}
	
	private function doReportAbilties()
	{
		return [
				'read-report',
		];
	}
	
	private function doBillingAbilties()
	{
		return [
				'read-billing',
				'create-billing',
				'update-billing',
				'delete-billing',
		];
	}
	
}