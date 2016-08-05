<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Discount;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class DiscountTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;

    public function transform(Discount $discount)
    {
        return [
            'id' => $this->encode($discount->id),
            'name' => $discount->name,
            'amount' => $discount->amount,
        ];
    }

}
