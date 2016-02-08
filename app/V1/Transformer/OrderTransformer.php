<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Order;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;
use Sikasir\V1\User\Company;
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
    
    
    protected $availableIncludes = [
        'outlet',
        'operator',
        'customer',
        'variants',
        'tax',
        'discount',
        'voidby',
    ];

    public function transform(Order $order)
    {
        
        $data = [
            'id' => $this->encode($order->id),
            'no_order' => $order->no_order,
            'note' => $order->note,
            'created_at' => $order->created_at,
            'void' => (boolean) $order->void,
            'paid' => (boolean) $order->paid,
        ];
        
        if ($order->void) {
            $data['void_note'] = $order->void_note;
        }
        
        if(isset($order->pivot)) {
            $data['total'] = $order->pivot->total;
            $data['nego'] = $order->pivot->nego;
        }
        
        return $data;
        
    }
    
    public function includeVariants(Order $order, ParamBag $params = null)
    {
        $collection = $order->variants;
        
        return $this->collection($collection, new VariantTransformer);
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
    
    public function includeTax(Order $order)
    {
        $item = $order->tax;
        
        return $this->item($item, new TaxTransformer);
    }
    
    public function includeDiscount(Order $order)
    {
        $item = $order->discount;
        
        return ! is_null($item) ? $this->item($item, new TaxTransformer) : null;
    }
    
    public function includeOperator(Order $order)
    {
        $user = $order->operator;
        
        if ($user->userable instanceof Company) {
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
        
        if (isset($user) && $user->userable instanceof Company) {
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
