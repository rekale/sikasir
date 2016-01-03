<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\BusinessField;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class BusinessFieldTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform(BusinessField $businessField)
    {
        return [
            'name' => $businessField->name,
        ];
    }
  
}
