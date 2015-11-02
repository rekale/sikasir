<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\Outlets\Customer;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class CustomerTransformer extends TransformerAbstract
{
    use \Sikasir\Traits\IdObfuscater;
    
    public function transform(Customer $customer)
    {
        return [
            'id' => $this->encode($customer->id),
            'name' => $customer->name,
            'email' => $customer->email,
            'sex' => $customer->sex,
            'address' => $customer->address, 
            'phone'=> $customer->phone,
            'pos_code' => $customer->pos_code,
            'icon' => $customer->icon
            
        ];
    }
    
}
