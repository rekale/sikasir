<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class BestReportTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater;
   
    
    public function transform($collection)
    {
        return [
            'id' => $this->encode($collection->id),
            'name' => $collection->name, 
            'total' => (int) $collection->total,
            'amounts' => (int) $collection->amounts,
        ];
        
    }
    
}
