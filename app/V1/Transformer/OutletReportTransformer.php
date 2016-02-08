<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Outlet;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;
use \Sikasir\V1\Traits\IdObfuscater;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutletReportTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'best_products',
    ];
    
    public function transform(Outlet $outlet)
    {
        return [
            'id' => $this->encode($outlet->id),
            'name' => $outlet->name,
            'revenue' => $outlet->revenue,
            'profit' => $outlet->profit,
            'transaction' => $outlet->transaction,
        ];
    }
    
    public function includebestProducts(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $outlet->bestProducts;
        
        return $this->collection($collection, new BestReportTransformer);
    }

}
