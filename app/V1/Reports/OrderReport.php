<?php

namespace Sikasir\V1\Reports;

class OrderReport extends Report
{
	public function getResult()
	{
		return $this->query
					->selectRaw(
	                   "orders.*, " .
					   "products.calculation_type, " .
					   "customers.id as customer_id, " .
					   "customers.name as customer_name, " .
					   "variants.name as variant_name, " .
					   "products.unit, " .
					   "order_variant.total as order_total, " .
					   " order_variant.price * order_variant.total  as gross_sales, " .
					   " variants.price  - order_variant.nego * order_variant.weight as gross_sales_weight, " .
					   " variants.price_init * order_variant.total as sales, " .
					   " variants.price_init * order_variant.weight as sales_weight, " .
					   "order_variant.nego * order_variant.total as sales_nego, " .
					   "order_variant.nego * order_variant.weight as sales_nego_weight "
	               )
				   ->join('customers', 'orders.customer_id', '=', 'customers.id')
	               ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
	               ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
				   ->join('products', 'products.id', '=', 'variants.product_id')
	               ->whereBetween('orders.created_at', $this->dateRange)
	               ->groupBy('variants.id');
	}


	public function getResultFor($id)
	{
		throw new \Exception('not implemented');
	}

	public function isVoid()
	{
		$this->query = $this->query
							->whereExists(
					            function ($closureQuery)
					            {
					                $closureQuery->selectRaw(1)
					                             ->from('voids')
					                             ->whereRaw('voids.order_id = orders.id');
					            }
					        );
		return $this;
	}

	/**
	 *
	 * @return $this
	 */
	public function isNotVoid()
	{
		$this->query = $this->query
							->whereNotExists(
								function ($closureQuery)
								{
									$closureQuery->selectRaw(1)
									->from('voids')
									->whereRaw('voids.order_id = orders.id');
								}
							);
		return $this;
	}

	/**
	 * get the order that have debt
	 * $settled is false if want to get debts that still not paid
	 * $settled is true if want to get debts that have been paid
	 * $settled is null if wanto get both not paid and have been paid
	 *
	 * @return $this
	 */
	public function haveDebt()
	{
		$this->query = $this->query
							->whereExists(
								function ($closureQuery)
								{
									$closureQuery->selectRaw(1)
												->from('debts')
												->whereRaw('debts.order_id = orders.id');
								}
							);

		return $this;
	}

	/**
	 * get the order that its debt has been settled
	 *
	 * @return $this
	 */
	public function haveDebtAndSettled()
	{
		$this->query = $this->query->whereExists(
			function ($closureQuery)
			{
				$closureQuery->selectRaw(1)
							->from('debts')
							->whereRaw('debts.order_id = orders.id')
							->whereNotNull('paid_at');
			}
		);

		return $this;
	}

	/**
	 * get the order that its debt has not been settled
	 *
	 * @return $this
	 */
	public function haveDebtAndNotSettled()
	{
		$this->query = $this->query->whereExists(
				function ($closureQuery)
				{
					$closureQuery->selectRaw(1)
					->from('debts')
					->whereRaw('debts.order_id = orders.id')
					->whereNull('paid_at');
				}
		);

		return $this;
	}

	/**
	 * get the order that have debt
	 *
	 *@return $this
	 */
	public function dontHaveDebt()
	{
		$this->query = $this->query->whereNotExists(
			function ($closureQuery)
			{
				$closureQuery->selectRaw(1)
				->from('debts')
				->whereRaw('debts.order_id = orders.id');
			}
		);

		return $this;
	}

}
