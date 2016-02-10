<?php

namespace Sikasir\V1\Repositories\Settings;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Transactions\Payment;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerable;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class PaymentRepository extends EloquentRepository implements OwnerableRepo
{
    use EloquentOwnerable;

    public function __construct(Payment $model) 
    {
        parent::__construct($model);
    }
   
    public function getReportsForCompany($companyId)
    {
        return $this->queryForOwner($companyId)
                    ->selectRaw(
                        'payments.*, '
                        . 'count(orders.id) as transaction_total, '
                        . 'sum( (variants.price - order_variant.nego) * order_variant.total ) as amounts'
                    )
                    ->join('orders', 'payments.id', '=', 'orders.payment_id')
                    ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                    ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
                    ->groupBy('payments.id')
                    ->paginate();
    }
}
