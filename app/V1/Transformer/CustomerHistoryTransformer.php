<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Customer;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class CustomerHistoryTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform($customer)
    {
        return [
            'date' => $customer->date,
            'variant_total' => (int) $customer->variant_total,
            'price_total' => (int) $customer->price_total,
        ];
    }
    
}
