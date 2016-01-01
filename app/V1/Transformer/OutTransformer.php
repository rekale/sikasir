<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Out;
use \Sikasir\V1\Traits\IdObfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutTransformer extends TransformerAbstract
{
     use IdObfuscater;
    
    protected $availableIncludes = [
        'stocks',
    ];

    public function transform(Out $out)
    {
        
        $data = [
            'id' => $this->encode($out->id),
            'user' => $out->user->name,
            'note' => $out->note,
            'input_at' => $out->input_at,
        ];
        
        if (isset($out->pivot)) {
            $data['out_total'] = $out->pivot->total;
        }
        
        return $data;
    }
    
    public function includeStocks(Out $out)
    {
        $collection = $out->stocks;
        
        return $this->collection($collection, new StockTransformer);
    }
}
