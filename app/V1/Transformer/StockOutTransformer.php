<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\StockOut;
use \Sikasir\V1\Traits\IdObfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class StockOutTransformer extends TransformerAbstract
{
    use IdObfuscater;

    public function transform(StockOut $out)
    {
        return [
            'id' => $this->encode($out->id),
            'user' => $out->user->name,
            'name' => $out->variant->name,
            'note' => $out->note,
            'quantity' => $out->total,
            'input_at' => $entry->input_at,

        ];
    }
    
    

}
