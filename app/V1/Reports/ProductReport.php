<?php

namespace Sikasir\V1\Reports;

class ProductReport extends Report
{
	public function getResult()
	{
		return $this->query
					->selectRaw(
                        'products.*, '
                        . 'sum(order_variant.total) as total, '
                        . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereBetween('order_variant.created_at', $this->dateRange)
                    ->groupBy('products.id');
	}
	
	/**
	 * 
	 * return $this
	 */
	public function bestSeller()
	{
		$this->query = $this->query
							->orderBy('total', 'desc')
							->orderBy('amounts', 'desc');
		
		return $this;
	}
	
	public function getResultFor($id)
	{
		throw new \Exception('not implemented');
	}
}