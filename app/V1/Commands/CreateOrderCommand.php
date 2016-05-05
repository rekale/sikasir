<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;

class CreateOrderCommand extends CreateCommand 
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
			
			$this->data['user_id'] = $this->auth->currentUser()->id;
			
			$order = $this->factory->create($this->data);
			
			foreach ($this->data['variants'] as $variant) {
				
				$order->variants()->attach(
					$variant['id'],
					[
						'total' => $variant['quantity'],
						'nego' => $variant['nego'],
					]
				);
				
			}
			
			//jika transaksi di hutangin
			if( $this->orderIsDebt() ) {
				
			}
			
		});
	}
	
	/**
	 * 
	 * @return boolean
	 */
	private function orderIsDebt()
	{
		return isset($this->data['due_date']) && isset($this->data['total']);
	}
}