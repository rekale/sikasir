<?php

namespace Sikasir\V1\Reports;

class CategoryReport extends Report
{
	public function getResult()
	{
		return $this->query
					->selectRaw(
                        'categories.*, '
                        . 'sum(order_variant.total) as total, '
                        . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                    )
                    ->join('products', 'categories.id', '=', 'products.category_id')
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereBetween('order_variant.created_at', $this->dateRange)
                    ->groupBy('categories.id');
	}
	
	
	public function getResultFor($id)
	{
		throw new \Exception('not implemented');
	}
	
	/**
	 * to get categories report from specific outlet
	 * 
	 * @param integer|null $id
	 */
	public function forOutlet($id = null)
	{
		if(! is_null($id))
		{
			$this->query = $this->query->where('products.outlet_id', '=', $id);
		}
		
		return $this;
	}
}