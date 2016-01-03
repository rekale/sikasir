<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Entry;
use \Sikasir\V1\Traits\IdObfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class EntryTransformer extends TransformerAbstract
{
    use IdObfuscater;
    
    protected $availableIncludes = [
        'stocks',
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
    
    public function includeStocks(Entry $entry)
    {
        $collection = $entry->stocks;
        
        return $this->collection($collection, new StockTransformer);
    }
    
    

}
