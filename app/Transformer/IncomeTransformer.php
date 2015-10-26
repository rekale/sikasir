<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\Finances\Income;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class IncomeTransformer extends TransformerAbstract
{
    use \Sikasir\Traits\IdObfuscater;
    
    public function transform(Income $income)
    {
        return [
            'id' => $this->encode($income->id),
            'total' =>(int) $income->total,
            'note' => $income->note,
            'date' => (string) $income->created_at,
            
        ];
    }
  
}
