<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Orders\Debt;
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
						'weight' => $variant['weight'],
						'price' => $variant['price'],
						'nego' => $variant['nego'],
					]
				);

				//kurangin current stock variantnya
				$currVariant = Variant::findOrFail($variant['id']);
				$currVariant->current_stock = $currVariant->current_stock - $variant['quantity'];
				$currVariant->current_weight = $currVariant->current_weight - $variant['weight'];
				$currVariant->save();


			}


			//jika transaksi di hutangin
			if( isset($this->data['isDebt']) && $this->data['isDebt'] ) {

				$debt = new Debt([
						'total' => $this->data['total'],
						'due_date' => $this->data['due_date']
				]);


				$order->debt()->save($debt);
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
