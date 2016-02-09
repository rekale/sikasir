<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Orders\Void;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class VoidTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    

    protected $availableIncludes = [
        'operator',
    ];
    
    public function transform(Void $void)
    {
        
        return [
            'id' => $this->encode($void->id),
            'note' => $void->note,
        ];
        
    }
    
    public function includeOperator(Void $void)
    {
        return $this->item($void->operator, new UserTransformer);
    }
    
    
}
