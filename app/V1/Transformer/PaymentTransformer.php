<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Transactions\Payment;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class PaymentTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    public function transform(Payment $payment)
    {
        return [
            'id' => $this->encode($payment->id),
            'name' => $payment->name,
            'description' => $payment->description,
            
        ];
    }
  
}
