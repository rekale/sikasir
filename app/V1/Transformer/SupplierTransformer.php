<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Suppliers\Supplier;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class SupplierTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;

    public function transform(Supplier $supplier)
    {
        return [
            'id' => $this->encode($supplier->id),
            'name' => $supplier->name,
            'email' => $supplier->email,
            'address' => $supplier->address,
            'phone'=> $supplier->phone,
        ];
    }

}
