<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\StockDetail;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class ItemTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    
     protected $availableIncludes = [
        'entries',
        'outs',
        'opnames',
        'stock',
        'variant',
    ];


    public function transform(StockDetail $stock)
    {
        $data = [
            'id' => $this->encode($stock->id),
            'outlet_stock' => $stock->total,
        ];
        
        if (isset($stock->pivot)) {
            $foreign = explode('_', $stock->pivot->getForeignKey());
            $key = $foreign[0] . '_total';
            $data[$key] = $stock->pivot->total;
        }
        
        return $data;
    }
    
     public function includeStock(StockDetail $item, ParamBag $params = null)
    {
        $collection = $item->stock;
        
        return $this->item($collection, new StockTransformer);
    }
    
    public function includeVariant(StockDetail $stock, ParamBag $params = null)
    {
        $item = $stock->variant;
        
        return $this->item($item, new VariantTransformer);
    }
    
    public function includeEntries(StockDetail $stock, ParamBag $params = null)
    {
        $collection = $this->setData(
            $stock->entries(), $params['per_page'][0], $params['current_page'][0] 
        )->result();
        
        return $this->collection($collection, new InventoryTransformer);
    }
    
    public function includeOuts(StockDetail $stock, ParamBag $params = null)
    {
        $collection = $this->setData(
            $stock->outs(), $params['per_page'][0], $params['current_page'][0] 
        )->result();
        
        return $this->collection($collection, new OutTransformer);
    }
    
    public function includeOpnames(StockDetail $stock, ParamBag $params = null)
    {
        $collection = $this->setData(
            $stock->opnames(), $params['per_page'][0], $params['current_page'][0] 
        )->result();
        
        return $this->collection($collection, new OpnameTransformer);
    }
    

}
