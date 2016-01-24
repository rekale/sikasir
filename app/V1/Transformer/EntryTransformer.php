<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Entry;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class EntryTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'items',
        'operator',
    ];

    public function transform(Entry $entry)
    {
        
        $data = [
            'id' => $this->encode($entry->id),
            'note' => $entry->note,
            'input_at' => $entry->input_at,
        ];
        
        if (isset($entry->pivot)) {
            $data['entry_total'] = $entry->pivot->total;
        }
        
        return $data;
    }
    
    public function includeItems(Entry $entry, ParamBag $params = null)
    {
       $collection = $entry->items;
        
       return $this->collection($collection, new ItemTransformer);
    }
    
    public function includeOperator(Entry $entry, ParamBag $params = null)
    {
       $item = $entry->operator;
        
        return $this->item($item, new UserTransformer);
    }
    
}
