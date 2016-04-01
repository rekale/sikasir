<?php

namespace Sikasir\V1\User;


use Sikasir\V1\Interfaces\AuthInterface;

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
	public function __construct(AuthInterface $auth)
	{
		$this->user = $auth->currentUser();
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
		if (in_array( 5, $privileges)) {
			$this->user->allow($this->doVoidOrder());
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
		if (! in_array( 5, $privileges)) {
			$this->user->disallow($this->doVoidOrder());
		}
	}
	
	
	public function managerDefault()
	{
		$default = [];
		
		$default[] = [
			'edit-supplier',
        	'edit-settings', //tax, discount, payment, printer
            'edit-cashier',
        	'edit-employee',
		];
		
		$default[] = $this->cashierDefault();
		
		return $default;
		
		
	}
	
	public function cashierDefault()
	{
		return [
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