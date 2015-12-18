<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Stocks\StockDetail;
use \Sikasir\V1\Traits\IdObfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class StockDetailTransformer extends TransformerAbstract
{
    use IdObfuscater;

    public function transform(StockDetail $detail)
    {
        return [
            'id' => $this->encode($detail->id),
            'name' => $detail->variant->name,
            'code' => $detail->variant->code,
            'quantity' => $detail->total,
            'price' => (int) $detail->variant->price,

        ];
    }

}
