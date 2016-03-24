<?php

namespace Sikasir\V1\Reports;

use Sikasir\V1\interfaces\ReportInterface;
use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

class PaymentReport extends Report 
{
	public function getResult() 
	{
		return $this->query
					->selectRaw(
						'payments.*, '
						. 'count(orders.id) as transaction_total, '
						. 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
					)
			        ->join('orders', 'payments.id', '=', 'orders.payment_id')
			        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
			        ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
			        ->whereBetween('order_variant.created_at', $this->dateRange)
			        ->groupBy('payments.id');
	}
}