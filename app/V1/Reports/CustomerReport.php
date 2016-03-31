<?php

namespace Sikasir\V1\Reports;

class CustomerReport extends Report
{
	public function getResultFor($id)
	{
		return $this->query
					->findOrFail($id)
					->orders()
                        ->selectRaw(
                           'orders.created_at as date, '
                           . 'sum(order_variant.total) as variant_total, '
                           . 'sum(variants.price) as price_total'
                        )
                        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                        ->join('variants', 'variants.id', '=', 'order_variant.variant_id')
                        ->whereBetween('orders.created_at', $this->dateRange)
                        ->groupBy('orders.created_at')
                        ->orderBy('date');
	}
	
	public function getResult()
	{
		throw new \Exception('not implemented');
	}
}