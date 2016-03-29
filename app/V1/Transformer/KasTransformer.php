<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Finances\Income;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class KasTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform($income)
    {
        return [
            'id' => $this->encode($income->id),
            'total' =>(int) $income->total,
            'note' => $income->note,
            'date' => (string) $income->created_at,
            
        ];
    }
  
}
