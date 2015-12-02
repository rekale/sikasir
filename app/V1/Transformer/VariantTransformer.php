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
