<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Products\Variant;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class VariantTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater;
   
    protected $availableIncludes = [
        'stocks',
    ];
   
    public function transform(Variant $variant)
    {
        
        return [
            'id' => $this->encode($variant->id),
            'name' => $variant->name, 
            'code' => $variant->code,
            'price_init' => (int) $variant->price_init,
            'price' => (int) $variant->price,
            'track_stock' => (boolean) $variant->track_stock,
            'stock' => (int) $variant->stock,
            'alert' => (boolean) $variant->alert,
            'alert_at' => (int) $variant->alert_at,
        ];
    }
    
    public function includeStocks(Variant $variant)
    {
        return $this->collection($variant->stocks, new StockTransformer);
    }
    
    
    
   
    
}
