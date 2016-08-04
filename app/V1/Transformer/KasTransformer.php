<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Finances\Income;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class KasTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater;

    protected $availableIncludes = [
        'outlet',
    ];

    public function transform($income)
    {
        return [
            'id' => $this->encode($income->id),
            'total' =>(int) $income->total,
            'note' => $income->note,
            'created_at' => (string) $income->created_at,

        ];
    }

    public function includeOutlet($kas)
    {
        return $this->item($kas->outlet, new OutletTransformer);
    }
}
