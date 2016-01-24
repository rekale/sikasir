<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Out;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutTransformer extends TransformerAbstract
{
     use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'items',
        'operator',
    ];

    public function transform(Out $out)
    {
        
        $data = [
            'id' => $this->encode($out->id),
            'note' => $out->note,
            'input_at' => $out->input_at,
        ];
        
        if (isset($out->pivot)) {
            $data['out_total'] = $out->pivot->total;
        }
        
        return $data;
    }
    
    public function includeItems(Out $out, ParamBag $params = null)
    {
       $collection = $out->items;
        
        return $this->collection($collection, new ItemTransformer);
    }
    
    public function includeOperator(Out $out, ParamBag $params = null)
    {
       $item = $out->operator;
        
        return $this->item($item, new UserTransformer);
    }
}
