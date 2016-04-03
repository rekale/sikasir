<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Util\Obfuscater;
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
        	'id' => Obfuscater::encode($businessField->id),
            'name' => $businessField->name,
        ];
    }
  
}
