<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Silber\Bouncer\Database\Ability;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class AbilityTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform($ability)
    {
        return $ability;
    }
  
}
