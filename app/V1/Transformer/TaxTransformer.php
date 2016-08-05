<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Tax;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class TaxTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;

    protected $availableIncludes = ['outlets'];

    public function transform($tax)
    {
        return [
            'id' => $this->encode($tax->id),
            'name' => $tax->name,
            'amount' => $tax->amount,
        ];
    }

    public function includeOutlets(Tax $tax)
    {
        return $this->collection($tax->outlets, new OutletTransformer);
    }

}
