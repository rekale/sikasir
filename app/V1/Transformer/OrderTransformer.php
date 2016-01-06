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
    
    protected $defaultIncludes = [
        'stocks',
    ];

    public function transform(Order $order)
    {
        
        return [
            'id' => $this->encode($order->id),
            'note' => $order->note,
            'total' => $order->total,
        ];
        
    }
    
    public function includeStocks(Order $order, ParamBag $params = null)
    {
        $collection = $this->setData(
            $order->stocks(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new StockTransformer);
    }
}
