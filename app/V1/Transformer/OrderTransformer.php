<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Order;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;

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
        'void',
    ];

    public function transform(Order $order)
    {
        
        $data = [
            'id' => $this->encode($order->id),
            'no_order' => $order->no_order,
            'note' => $order->note,
            'revenue' => $order->revenue,
            'profit' => $order->profit,
            'paid' => (boolean) $order->paid,
            'created_at' => $order->created_at,
        ];
        
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
        
        return $this->item($item, new TaxTransformer);
    }
    
    public function includeOperator(Order $order)
    {
        $item = $order->operator;
        
        return $this->item($item, new UserTransformer); 
    }
    
    public function includeVoid(Order $order)
    {
        $item = $order->void;
        
        return $this->item($item, new VoidTransformer); 
    }
    
    
}
