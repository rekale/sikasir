<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Company;
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
        'product',
    ];
   
    public function transform(Variant $variant)
    {
        
        $rules = [
            'id' => $this->encode($variant->id),
            'name' => $variant->name, 
            'barcode' => $variant->barcode, 
            'icon' => $variant->icon,
            'price_init'  => (int) $variant->price_init,
            'price' => (int) $variant->price,
            'countable' => (boolean) $variant->countable,
            'track_stock' => (boolean) $variant->track_stock,
            'stock' => (int) $variant->stock,
            'alert' => (boolean) $variant->alert,
            'alert_at' => (int) $variant->alert_at,
        ];
        
        if (isset($product->pivot)) {
            $foreign = explode('_', $product->pivot->getForeignKey());
            $key = $foreign[0] . '_total';
            $rules[$key] = $product->pivot->total;
        }
        
        if (isset($product->pivot->nego)) {
            $rules['nego'] = $product->pivot->nego;
        }
        
        return $rules;
    }
   
    public function includeProduct(Variant $variant)
    {
        return $this->item($variant->product, new ProductTransformer);
    }
    
    
    
   
    
}
