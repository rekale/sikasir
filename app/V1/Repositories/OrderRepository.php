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

            foreach ($data['products'] as $product)
            {
                $order->products()->attach($product['id'], ['total' => $product['quantity']]);
            }
            
        });
        
    }
   /**
     * get outlet's voided orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getUnvoidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('void', '=', false)
                ->with($with)
                ->paginate($perPage);
    }
    
    
    /**
     * get outlet's voided orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getVoidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('void', '=', true)
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's paid only orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getPaidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('paid', '=', true)
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's unpaid only orders
     *
     * @param integer $outletId
     * @param integer ownerId
     *
     * @return Collection | Paginator
     */
    public function getUnpaidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('paid', '=', false)
                ->with($with)
                ->paginate($perPage);
    }
    

}
