<?php

namespace Sikasir\V1\Commands;

use Sikasir\V1\Commands\CreateCommand;
use Sikasir\V1\Interfaces\AuthInterface;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;

class CreateInventoryCommand extends CreateCommand
{
	private $auth;
	private $stockIn;
	private $stockOut;
	private $opname;
	private $po;

	/**
	 *
	 * @param AuthInterface $auth
	 *
	 * @return $this
	 */
	public function setAuth(AuthInterface $auth)
	{
		$this->auth = $auth;
		$this->stockOut = false;
		$this->stockIn = false;
		$this->opname = false;
		$this->po = false;

		return $this;
	}

	/**
	*
	*
	* @return $this
	*/
	public function isStockIn()
	{
		$this->stockIn = true;

		return $this;
	}

	/**
	*
	*
	* @return $this
	*/
	public function isStockOut()
	{
		$this->stockOut = true;

		return $this;
	}

	/**
	*
	*
	* @return $this
	*/
	public function isOpname()
	{
		$this->opname = true;

		return $this;
	}

	/**
	*
	*
	* @return $this
	*/
	public function isPO()
	{
		$this->po = true;

		return $this;
	}

	public function execute()
	{
		\DB::beginTransaction();

		try {
			$inventory = $this->factory->create($this->data);

			foreach ($this->data['variants'] as $variant) {

				$inventory->variants()->attach(
						$variant['id'],
						[
							'total' => $variant['total'],
							'weight' => $variant['weight'],
						]
				);

				$currentVariant = Variant::findOrFail($variant['id']);

				if($currentVariant->countable) {

					if ($this->stockIn || $this->po || $this->opname) {
						$currentVariant->current_stock = $currentVariant->current_stock + $variant['total'];
						$currentVariant->current_weight = $currentVariant->current_weight + $variant['weight'];
						$currentVariant->save();
					}
					if ($this->stockOut) {
						$currentVariant->current_stock = $currentVariant->current_stock - $variant['total'];
						$currentVariant->current_weight = $currentVariant->current_weight - $variant['weight'];
						$currentVariant->save();
					}
				}
			}

            \DB::commit();
        }
        catch (\Exception $e) {
            \DB::rollBack();

            throw $e;
        }
		catch (\Throwable $e) {
            \DB::rollBack();

            throw $e;
        }

		return $inventory->id;

	}

}
