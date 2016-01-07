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
    
    public function includeItems(Out $out, ParamBag $params = null)
    {
       $collection = $this->setData(
            $out->items(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new ItemTransformer);
    }
}
