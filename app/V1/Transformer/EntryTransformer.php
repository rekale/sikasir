<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Entry;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
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
    ];

    public function transform(Entry $entry)
    {
        
        $data = [
            'id' => $this->encode($entry->id),
            'user' => $entry->user->name,
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
       $collection = $this->setData(
            $entry->items(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new ItemTransformer);
    }
    
}
