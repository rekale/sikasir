<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Debt;
use \Sikasir\V1\Traits\IdObfuscater;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class DebtTransformer extends TransformerAbstract
{
    use IdObfuscater;
    
    public function transform(Debt $debt)
    {
        
        return [
            'id' => $this->encode($debt->id),
            'total' => $debt->total,
            'due_date' => $debt->due_date,
            'paid_at' => $debt->paid_at,
        ];
        
    }
    
}
