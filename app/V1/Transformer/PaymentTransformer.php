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
    
    protected $availableIncludes = [
        'orders'
    ];
    
    public function transform(Payment $payment)
    {
        $data = [
            'id' => $this->encode($payment->id),
            'name' => $payment->name,
            'description' => $payment->description,
        ];    
        
        if( isset($payment->transaction_total) ) {
            $data['transaction_total'] = $payment->transaction_total;
            $data['amounts'] = $payment->amounts;
        }
        
        return $data;
    }
  
    public function includeOrders(Payment $payment)
    {
        return $this->collection($payment->orders, new OrderTransformer);
    }
}
