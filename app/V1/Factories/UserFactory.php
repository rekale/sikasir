<?php

namespace Sikasir\V1\Factories;

use Sikasir\V1\User\User;
use Sikasir\V1\Util\Obfuscater;

class UserFactory extends EloquentFactory
{
	
	
	public function create(array $data)
	{
		\DB::beginTransaction();
			
		try {
			
			$data['password'] = bcrypt($data['password']);
			
			$user = parent::create($data);
				
			$this->addPrivileges($user, $data['privileges']);
				
			$outletIds = Obfuscater::decode($data['outlet_id']);
				
			$user->outlets()->attach($outletIds);
				
		
		}
		catch (\Exception $e) {
			
			\DB::rollback();
			
		}
		
		\DB::commit();
		
		return $user;
	}
	
	private function addPrivileges(User $user, $privileges)
	{
		if (in_array( 1, $privileges)) {
			$user->allow($this->doProductAbilities());
		}
		if (in_array( 2, $privileges)) {
			$user->allow($this->doOrderAbilties());
		}
		if (in_array( 3, $privileges)) {
			$user->allow($this->doReportAbilties());
		}
		if (in_array( 4, $privileges)) {
			$user->allow($this->doBillingAbilties());
		}
	}
	
	public function doProductAbilities()
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
	
	public function doOrderAbilties()
	{
		return [
				'create-order',
				'read-order',
				'void-order',
				'update-order',
		];
	}
	
	public function doReportAbilties()
	{
		return [
				'read-report',
		];
	}
	
	public function doBillingAbilties()
	{
		return [
				'read-billing',
				'create-billing',
				'update-billing',
				'delete-billing',
		];
	}
}