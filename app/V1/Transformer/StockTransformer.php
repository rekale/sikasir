<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Stock;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class StockTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $defaultIncludes = [
        'product',
    ];
    
     protected $availableIncludes = [
        'items',
    ];


    public function transform(Stock $stock)
    {
        $data = [
            'id' => $this->encode($stock->id),
            'total' => $stock->total,
        ];
        
        if (isset($stock->pivot)) {
            $data['pivot_total'] = $stock->pivot->total;
        }
        
        return $data;
    }
    
    public function includeProduct(Stock $stock)
    {
        $item = $stock->product;
        
        return $this->item($item, new ProductTransformer);
    }
    
    public function includeItems(Stock $stock, ParamBag $params = null)
    {
        $collection = $stock->items;
        
        return $this->collection($collection, new ItemTransformer);
    }
}
