<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\User\User;

use Sikasir\V1\Products\Product;

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

			//when new outlet is created, assign owner to every new outlet
			$owner = User::whereTitle('owner')
							->whereCompanyId($this->auth->getCompanyId())
							->first();
			$owner->outlets()->attach($outlet->id);

			//insert products (for all outlets) to new outlet
			$products = Product::with('variants')->distinct()
								->whereForAllOutlets(true)
								->whereCompanyId($this->auth->getCompanyId())
								->get();

			foreach ($products as $product) {
				$product->outlet_id = $outlet->id;
				$newProduct = Product::create($product->toArray());

				foreach($product->variants as $variant) {

					$variant->stock = 0;
					$variant->current_stock = 0;
					$variant->current_weight = 0;

					$newProduct->variants()->create($variant->toArray());
				}

			}





		});
	}
}
