<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Opname;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OpnameTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'items',
    ];

    public function transform(Opname $opname)
    {
        
        $data = [
            'id' => $this->encode($opname->id),
            'user' => $opname->user->name,
            'note' => $opname->note,
            'status' => (boolean) $opname->status,
            'input_at' => $opname->input_at,
        ];
        
        if (isset($opname->pivot)) {
            $data['opname_total'] = $opname->pivot->total;
        }
        
        return $data;
    }
    
    public function includeItems(Opname $opname, ParamBag $params = null)
    {
       $collection = $this->setData(
            $opname->items(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new ItemTransformer);
    }
    
}
