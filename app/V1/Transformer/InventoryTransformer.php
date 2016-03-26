<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class InventoryTransformer extends TransformerAbstract
{
    use IdObfuscater;
    
    protected $availableIncludes = [
        'operator',
        'variants',
    ];

    public function transform($entry)
    {
        
        $data = [
            'id' => $this->encode($entry->id),
            'note' => $entry->note,
            'input_at' => $entry->input_at,
        ];
        
        if (isset($entry->pivot)) {
            $data['total'] = $entry->pivot->total;
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
