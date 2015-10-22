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
    
    public function transform(Income $income)
    {
        return [
            'id' => (int) $income->id,
            'total' =>(int) $income->total,
            'note' => $income->note,
            'date' => (string) $income->created_at,
            
        ];
    }
  
}
