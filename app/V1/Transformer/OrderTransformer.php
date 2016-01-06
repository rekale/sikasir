<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Order;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OrderTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $defaultIncludes = [
        'stocks',
    ];
    
    protected $availableIncludes = [
        'outlet',
        'user',
        'customer',
        'voidby',
    ];

    public function transform(Order $order)
    {
        
        $data = [
            'id' => $this->encode($order->id),
            'note' => $order->note,
            'total' => $order->total,
            'void' => (boolean) $order->void,
        ];
        
        if ($order->void) {
            $data['void_note'] = $order->void_note;
        }
        
        return $data;
        
    }
    
    public function includeStocks(Order $order, ParamBag $params = null)
    {
        $collection = $this->setData(
            $order->stocks(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new StockTransformer);
    }
    
    public function includeCustomer(Order $order)
    {
        $item = $order->customer;
        
        return $this->item($item, new CustomerTransformer);
    }
    
    public function includeOutlet(Order $order)
    {
        $item = $order->outlet;
        
        return $this->item($item, new OutletTransformer);
    }
    
    public function includeUser(Order $order)
    {
        $user = $order->user;
        
        if ($user->userable instanceof Owner) {
            return $this->item($user->userable, new OwnerTransformer);
        }
        if ($user->userable instanceof Employee) {
            return $this->item($user->userable, new EmployeeTransformer);
        }
        if ($user->userable instanceof Cashier) {
            return $this->item($user->userable, new CashierTransformer);
        }
    }
    
    public function includeVoidby(Order $order)
    {
        $user = $order->voidBy;
        
        if (isset($user) && $user->userable instanceof Owner) {
            return $this->item($user->userable, new OwnerTransformer);
        }
        if (isset($user) && $user->userable instanceof Employee) {
            return $this->item($user->userable, new EmployeeTransformer);
        }
        if (isset($user) && $user->userable instanceof Cashier) {
            return $this->item($user->userable, new CashierTransformer);
        }
    }
    
    
}
