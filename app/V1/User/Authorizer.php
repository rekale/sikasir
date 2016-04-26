<?php

namespace Sikasir\V1\User;


class Authorizer 
{
	/**
	 * 
	 * @var User
	 */
	private $user;
	
	private $abilities;
	
	/**
	 * 
	 * @param User $user
	 */
	public function __construct(User $user = null)
	{
		$this->user = $user;
		$this->abilities = [];
	}
	
	public function setUser(User $user)
	{
		$this->user = $user;
		
		return $this;
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
	 * @return array
	 */
	public function giveAccess(array $privileges)
	{
		if (in_array( 1, $privileges)) {
			$this->abilities[] = 'edit-product';
			$this->user->allow($this->abilities);
		}
		if (in_array( 2, $privileges)) {
			$this->abilities[] = 'report-order';
			$this->user->allow($this->abilities);
		}
		if (in_array( 3, $privileges)) {
			$this->abilities[] = 'read-report';
			$this->user->allow($this->abilities);
		}
		if (in_array( 4, $privileges)) {
			$this->abilities[] = 'billing';
			$this->user->allow($this->abilities);
		}
		if (in_array( 5, $privileges)) {
			$this->abilities[] = 'void-order';
			$this->user->allow($this->abilities);
		}
		
		return $this->abilities;
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
			$this->abilities[] = 'edit-product';
			$this->user->allow($this->abilities);
		}
		if (! in_array( 2, $privileges)) {
			$this->abilities[] = 'report-order';
			$this->user->allow($this->abilities);
		}
		if (! in_array( 3, $privileges)) {
			$this->abilities[] = 'read-report';
			$this->user->allow($this->abilities);
		}
		if (! in_array( 4, $privileges)) {
			$this->abilities[] = 'billing';
			$this->user->allow($this->abilities);
		}
		if (! in_array( 5, $privileges)) {
			$this->abilities[] = 'void-order';
			$this->user->allow($this->abilities);
		}
		
	}
	
	public function ownerDefault()
	{
		$default = [];
	
		$default = [
			'edit-outlet',
		];
	
		$this->managerDefault();
	
		$this->abilities = array_merge($this->abilities, $default);
	
		return $this;
	
	}
	
	public function managerDefault()
	{
		$default = [];
		
		$default = [
			'edit-supplier',
        	'edit-settings', //tax, discount, payment, printer
            'edit-cashier',
        	'edit-employee',
		];
		
		$this->cashierDefault();

		$this->abilities = array_merge($this->abilities, $default);
		
		return $this;
		
	}
	
	/**
	 * 
	 * @return $this
	 */
	public function cashierDefault()
	{
		$default =  [
			'read-outlet',
			'read-customer',
        	'edit-customer',
        	'read-inventory',
        	'read-supplier',
        	'read-settings', //tax, discount, payment, printer
        	'read-cashier',
        	'read-employee', 
        	'read-product',
            'read-inventory',
        	'edit-inventory',
        	'read-order',
        	'edit-order',
		];
		
		$this->abilities = array_merge($this->abilities, $default);
		
		return $this;
	}
	
	
	private function doProductAbilities()
	{
		return [
			'edit-product',
		];
	}
	
	private function doOrderAbilties()
	{
		return [
			'report-order',
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
			'billing',
		];
	}
	
	public function doVoidOrder()
	{
		return [
			'void-order',	
		];
	}
	
}