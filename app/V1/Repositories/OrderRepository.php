<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\Company;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class OrderRepository extends EloquentRepository implements OwnerThroughableRepo
{
    
    use Traits\EloquentOwnerThroughable;
    
    public function __construct(Order $order) 
    {
        parent::__construct($order);
    }
    
    public function save(array $data) {
        
        \DB::transaction(function () use ($data) {
            
            $order = parent::save([
                'customer_id' => isset($data['customer_id']) ? $data['customer_id'] : null,
                'discount_id' => isset($data['discount_id']) ? $data['discount_id'] : null,
                'payment_id' => $data['payment_id'],
                'outlet_id' => $data['outlet_id'],
                'tax_id' => $data['tax_id'],
                'user_id' => $data['operator_id'],
                'note' => $data['note'],
            ]);

            foreach ($data['variants'] as $variant)
            {
                $order->variants()->attach(
                    $variant['id'], 
                    [
                        'total' => $variant['quantity'], 
                        'nego' => $variant['nego'],
                    ]
                );
            }
            
        });
        
    }
    
    public function getNoVoidAndDebtPaginated($outletId, $companyId, $dateRange, $with =[], $perPage = 15) {
        
        return $this->queryForOwnerThrough($companyId, $outletId, 'outlets')
                    ->with($with)
                    ->getRevenueAndProfit()
                    ->isNotVoid()
                    ->DontHaveDebt()
                    ->dateRange($dateRange)
                    ->paginate($perPage);
                    
    }
    
    /**
     * get outlet's voided orders
     *
     * @param integer $outletId
     * @param integer $companyId
     *
     * @return Collection | Paginator
     */
    public function getVoidPaginated($outletId, $companyId, $dateRange, $with =[],$perPage = 15)
    {
        return $this->queryForOwnerThrough($companyId, $outletId, 'outlets')
                    ->with($with)
                    ->isVoid()
                    ->dateRange($dateRange)
                    ->paginate($perPage);
    }
    
    /**
     * get outlet's unpaid only orders
     *
     * @param integer $outletId
     * @param integer companyId
     *
     * @return Collection | Paginator
     */
    public function getDebtPaginated($outletId, $companyId, $dateRange, $settled, $with =[],$perPage = 15)
    {
        $queryBuilder = $this->queryForOwnerThrough($companyId, $outletId, 'outlets')
                            ->with($with)
                            ->isNotVoid()
                            ->dateRange($dateRange);
        
        //get only the debts that has been settled
        if ($settled) {
            $queryBuilder->haveDebtAndSettled();
        }
        //get only the debts that has not been settled
        else {
            $queryBuilder->haveDebtAndNotSettled();
        }
                   
        return $queryBuilder->paginate($perPage);
    }
    
    public function search($field, $word, $with =[], $perPage = 15)
    {
    	
    }
    

}
