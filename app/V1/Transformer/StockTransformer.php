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
        'variant',
    ];
    
     protected $availableIncludes = [
        'entries',
        'outs',
    ];


    public function transform(Stock $stock)
    {
        $data = [
            'id' => $stock->id,
            'total' => $stock->total,
        ];
        
        if (isset($stock->pivot)) {
            $data['pivot_total'] = $stock->pivot->total;
        }
        
        return $data;
    }
    
    public function includeVariant(Stock $stock, ParamBag $params = null)
    {
        $item = $stock->variant;
        
        return $this->item($item, new VariantTransformer);
    }
    
    public function includeEntries(Stock $stock, ParamBag $params = null)
    {
        $collection = $stock->entries;
        
        return $this->collection($collection, new EntryTransformer);
    }
    
    public function includeOuts(Stock $stock, ParamBag $params = null)
    {
        $collection = $stock->outs;
        
        return $this->collection($collection, new OutTransformer);
    }
    

}
