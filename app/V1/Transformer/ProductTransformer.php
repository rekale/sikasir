<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Products\Product;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class ProductTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater;
   
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'variants',
    ]; 
    
    public function transform(Product $product)
    {
        return [
            'id' => $this->encode($product->id),
            'category' => $product->category->name ,
            'name' => $product->name, 
            'description' => $product->description, 
            'barcode' => $product->barcode,
            'unit' => $product->unit,
            'icon' => $product->icon,
        ];
    }
   
    public function includeVariants(Product $product)
    {
        $variants = $product->variants;
        
        return $this->collection($variants, new VariantTransformer);
    }
    
}
