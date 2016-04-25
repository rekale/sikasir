<?php

namespace Sikasir\V1\Reports;

class EmployeeReport extends Report
{
	public function getResult()
	{
		return $this->query
					->selectRaw(
			            'users.* ,'
			            . 'count(orders.id) as total, '
			            . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
			        )
			        ->join('orders', 'users.id', '=', 'orders.user_id')
			        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
			        ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
			        ->whereBetween('orders.created_at', $this->dateRange)
			        ->groupBy('users.id');
	}
	
	public function getResultFor($id)
	{
		return $this->query
					->findOrfail($id)
					->orders()
					->selectRaw(
							'variants.id as id, '
							. 'variants.name as name, '
							. 'count(orders.id) as total, '
							. 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts, '
							. 'orders.created_at as date'
							)
				->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
				->join('variants', 'order_variant.variant_id', '=', 'variants.id')
				->whereBetween('orders.created_at', $this->dateRange)
				->groupBy('variants.id');
	}
}