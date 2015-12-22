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
    
     protected $availableIncludes = [
        'stockentries',
    ];


    public function transform(Stock $stock)
    {
        return [
            'id' => $this->encode($stock->id),
            'name' => $stock->variant->name,
            'code' => $stock->variant->code,
            'price' => $stock->variant->price,
            'quantity' => $stock->total,
        ];
    }
    
    public function includeStockentries(Stock $stock, ParamBag $params = null)
    {
        $query = $this->setBuilder($stock->stockEntries());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new StockEntryTransformer);
    }
    

}
