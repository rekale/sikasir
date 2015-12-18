<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\StockEntry;
use \Sikasir\V1\Traits\IdObfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class StockEntryTransformer extends TransformerAbstract
{
    use IdObfuscater;

    public function transform(StockEntry $entry)
    {
        return [
            'id' => $this->encode($entry->id),
            'user' => $entry->user->name,
            'name' => $entry->variant->name,
            'note' => $entry->note,
            'quantity' => $entry->total,
            'created_at' => $entry->created_at,
        ];
    }
    
    

}
