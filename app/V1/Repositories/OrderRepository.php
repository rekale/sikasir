<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Orders\Order;
/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class OrderRepository extends EloquentRepository
{
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
                'total' => $data['total'],
                'paid' => $data['paid'],
            ]);

            foreach ($data['items'] as $item)
            {
                $order->items()->attach($item['id'], ['total' => $item['quantity']]);
            }
            
        });
        
    }
    
    /**
     * get outlet's voided orders
     *
     * @param integer $orderId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getVoidPaginated($orderId,Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($orderId, $owner)
                ->with($with)
                ->whereVoid(true)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's paid only orders
     *
     * @param integer $orderId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getPaidPaginated($orderId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($orderId, $owner)
                ->with($with)
                ->wherePaid(true)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's unpaid only orders
     *
     * @param integer $orderId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getUnpaidPaginated($orderId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($orderId, $owner)
                ->with($with)
                ->wherePaid(false)
                ->paginate($this->perPage($perPage));
    }
    

}
