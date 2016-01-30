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
        'product',
        'entries',
        'outs',
        'opnames',
        'purchases',
    ]; 
    
    public function transform(Product $product)
    {
        $main = [
            'id' => $this->encode($product->id),
            'name' => $product->name, 
            'description' => $product->description, 
            'icon' => $product->icon,
        ];
        
        $detail = [
            'barcode' => $product->barcode, 
            'unit' => $product->unit,
            'icon' => $product->icon,
            'price_init'  => (int) $product->price_init,
            'price' => (int) $product->price,
            'countable' => (boolean) $product->countable,
            'track_stock' => (boolean) $product->track_stock,
            'stock' => (int) $product->stock,
            'alert' => (boolean) $product->alert,
            'alert_at' => (int) $product->alert_at,
        ];
        
        if (isset($product->pivot)) {
            $foreign = explode('_', $product->pivot->getForeignKey());
            $key = $foreign[0] . '_total';
            $detail[$key] = $product->pivot->total;
        }
        
        return $product->isNotVariant() ? $main :
                array_merge($main, $detail);
        
    }
   
    public function includeVariants(Product $product)
    {
        $variants = $product->variants;
        
        return $this->collection($variants, new ProductTransformer);
    }
    
    public function includeCategory(Product $product)
    {
        $item = $product->category;
        
        return $this->item($item, new CategoryTransformer);
    }
    
    public function includeProduct(Product $variant)
    {   
        $item = $variant->product;
        
        return $this->item($item, new ProductTransformer);
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
