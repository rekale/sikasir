<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\User\Owner;
use Sikasir\Products\Variant;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class VariantTransformer extends TransformerAbstract
{
   use \Sikasir\Traits\IdObfuscater;
   
    public function transform(Variant $variant)
    {
        return [
            [
                'id' => $this->encode($variant->id),
                'name' => $variant->name, 
                'code' => $variant->code, 
                'price' => (int) $variant->price, 
                'unit' => $variant->unit
            ]
        ];
    }
   
    
}
