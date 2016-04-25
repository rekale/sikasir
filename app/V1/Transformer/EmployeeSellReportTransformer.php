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
    
    public function transform($data)
    {
        return [
        	'user_name' => $data->user_name,
        	'variant_name' => $data->variant_name,
            'sold' => (int) $data->total,
			'created_at' => $data->created_at->toDateString(),
        ];
    }
    
}
