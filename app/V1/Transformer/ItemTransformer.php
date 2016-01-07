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
    
    protected $defaultIncludes = [
        'variant',
    ];
    
     protected $availableIncludes = [
        'entries',
        'outs',
    ];


    public function transform(StockDetail $stock)
    {
        $data = [
            'id' => $this->encode($stock->id),
            'total' => $stock->total,
        ];
        
        if (isset($stock->pivot)) {
            $data['pivot_total'] = $stock->pivot->total;
        }
        
        return $data;
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
        
        return $this->collection($collection, new EntryTransformer);
    }
    
    public function includeOuts(StockDetail $stock, ParamBag $params = null)
    {
        $collection = $this->setData(
            $stock->outs(), $params['per_page'][0], $params['current_page'][0] 
        )->result();
        
        return $this->collection($collection, new OutTransformer);
    }
    

}