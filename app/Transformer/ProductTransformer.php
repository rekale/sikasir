<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\User\Owner;
use Sikasir\Products\Product;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class ProductTransformer extends TransformerAbstract
{
   use \Sikasir\Traits\IdObfuscater;
     
    
    public function transform(Product $product)
    {
        return [
            [
                'id' => $this->encode($product->id),
                'name' => $product->name, 
                'description' => $product->description, 
                'barcode' => $product->barcode, 
                'show' => $product->show
            ]
        ];
    }
   
    
}
