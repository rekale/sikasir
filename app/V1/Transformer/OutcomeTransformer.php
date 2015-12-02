<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Finances\Outcome;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutcomeTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform(Outcome $outcome)
    {
        return [
            'id' => $this->encode($outcome->id),
            'total' =>(int) $outcome->total,
            'note' => $outcome->note,
            'date' => (string) $outcome->created_at,
            
        ];
    }
  
}
