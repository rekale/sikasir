<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Transformer\InventoryTransformer;
use Sikasir\V1\Transformer\OpnameTransformer;
use Sikasir\V1\Transformer\PurchaseOrderTransformer;

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
        'category',
        'variants',
        'outlet',
        'entries',
        'outs',
        'opnames',
        'purchases',
    ]; 
    
    public function transform(Product $product)
    {
        $data = [
            'id' => $this->encode($product->id),
            'name' => $product->name, 
            'description' => $product->description, 
            'icon' => $product->icon,
        ];
        //if it get the product's best seller
        if (isset($product->total))
        {
            $data['total'] = (int) $product->total;
            $data['amounts'] = (int) $product->amounts;
        }
        
        return $data;
    }
   
    public function includeVariants(Product $product)
    {
        $variants = $product->variants;
        
        return $this->collection($variants, new VariantTransformer);
        
    }
    
    public function includeCategory(Product $product)
    {
        $item = $product->category;
        
        return $this->item($item, new CategoryTransformer);
    }
    
    public function includeOutlet(Product $variant)
    {   
        $item = $variant->outlet;
        
        return $this->item($item, new OutletTransformer);
        
    }
    
    public function includeEntries(Product $product)
    {
        $collection = $product->entries;
        
        return $this->collection($collection, new InventoryTransformer);
    }
    
    public function includeOuts(Product $product)
    {
        $collection = $product->outs;
        
        return $this->collection($collection, new InventoryTransformer);
    }
    
    public function includeOpnames(Product $product)
    {
        $collection = $product->opnames;
        
        return $this->collection($collection, new OpnameTransformer);
    }
    
    public function includePurchases(Product $product)
    {
        $collection = $product->purchases;
        
        return $this->collection($collection, new PurchaseOrderTransformer);
    }
    
}
