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
class StockDetailTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'stockentries',
        'stockouts',
    ];

    public function transform(StockDetail $detail)
    {
        return [
            'id' => $this->encode($detail->id),
            'category' => $detail->variant->product->category->name,
            'name' => $detail->variant->name,
            'code' => $detail->variant->code,
            'quantity' => $detail->total,
            'price' => (int) $detail->variant->price,

        ];
    }
    
    public function includeStockentries(StockDetail $detail, ParamBag $params = null)
    {
        $query = $this->setBuilder($detail->stockEntries());
       
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new StockEntryTransformer);
    }
    
    public function includeStockouts(StockDetail $detail, ParamBag $params = null)
    {
        $query = $this->setBuilder($detail->stockOuts());
       
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new StockOutTransformer);
    }

}
