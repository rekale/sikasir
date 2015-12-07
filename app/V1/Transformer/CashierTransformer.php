<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Cashier;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class CashierTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;

    public function transform(Cashier $cashier)
    {
        return [
            'id' => $this->encode($cashier->id),
            'name' => $cashier->name,
            'gender' => $cashier->gender,
            'address' => $cashier->address,
            'phone'=> $cashier->phone,
            'icon' => $cashier->icon,

        ];
    }

}
