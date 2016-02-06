<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\User\Company;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;


/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class CustomerRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;
    
    public function __construct(Customer $model) 
    {
        parent::__construct($model);
    }
    
    /**
     * 
     * @param integer $id
     * @param integer $companyId
     * @param array $timeRange
     * @return type
     */
    public function getHistoryTransactionForCompany($id, $companyId, $dateRange = [], $perPage = 15)
    {   
        $customer = $this->findForOwner($id, $companyId);
        
        return $customer->orders()
                        ->select(
                            \DB::raw(
                                'orders.created_at as date, '
                                . 'sum(order_variant.total) as variant_total, '
                                . 'sum(variants.price) as price_total'
                            )
                        )
                        ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                        ->join('variants', 'variants.id', '=', 'order_variant.variant_id')
                        ->where('orders.customer_id', '=', $id)
                        ->whereBetween('orders.created_at', $dateRange)
                        ->groupBy('orders.created_at')
                        ->orderBy('date')
                        ->paginate($perPage);
    }

}
