<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Util\Obfuscater;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class EmployeeSellReportTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform($variant)
    {
        return [
        	'id' => Obfuscater::encode($variant->id),
        	'name' => $variant->name,
            'variant_total' => (int) $variant->total,
            'price_total' => (int) $variant->amounts,
			'created_at' => $variant->date,
        ];
    }
    
}
