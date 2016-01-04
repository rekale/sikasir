<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Tax;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class TaxTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform($tax)
    {
        return [
            'name' => $tax->name,
            'amount' => $tax->amount,
            
        ];
    }
  
}
