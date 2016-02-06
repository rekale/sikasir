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
        'operator',
        'variants',
    ];

    public function transform(Opname $opname)
    {
        
        $data = [
            'id' => $this->encode($opname->id),
            'note' => $opname->note,
            'status' => (boolean) $opname->status,
            'input_at' => $opname->input_at,
        ];
        
        if (isset($opname->pivot)) {
            $data['total'] = $opname->pivot->total;
        }
        
        return $data;
    }
   
    public function includeVariants($entry, ParamBag $params = null)
    {
        $collection = $entry->variants;
        
        return $this->collection($collection, new VariantTransformer);
    }
    
    public function includeOperator($entry, ParamBag $params = null)
    {
       $item = $entry->operator;
        
        return $this->item($item, new UserTransformer);
    }
}
