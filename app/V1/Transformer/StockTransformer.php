<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\Stock;
use \Sikasir\V1\Traits\IdObfuscater;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class StockTransformer extends TransformerAbstract
{
    use IdObfuscater;

    public function transform(Stock $stock)
    {
        return [
            'id' => $this->encode($stock->id),
            'name' => $stock->variant->name,
            'code' => $stock->variant->code,
            'price' => $stock->variant->price,
            'quantity' => $stock->total,
        ];
    }
    
    

}
