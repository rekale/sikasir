<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Outlet;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;
use Sikasir\V1\Stocks\StockDetail;
use \Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Outlets\Printer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutletTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'users',
        'printers',
    ];
    
    protected $defaultIncludes = [
        'tax',
        'business_field',
    ];

    public function transform(Outlet $outlet)
    {
        return [
            'id' => $this->encode($outlet->id),
            'name' => $outlet->name,
            'address' => $outlet->address,
            'province' => $outlet->province,
            'city' => $outlet->city,
            'pos_code' => $outlet->pos_code,
            'phone1' => $outlet->phone1,
            'phone2' => $outlet->phone2,
            'icon' => $outlet->icon,

        ];
    }
    
    public function includeTax(Outlet $outlet)
    {
        $collection = $outlet->tax;
        
        return $this->item($collection, new TaxTransformer);
    }
    
    public function includeBusinessField(Outlet $outlet)
    {
        $collection = $outlet->businessField;
        
        return $this->item($collection, new BusinessFieldTransformer);
    }
    
    public function includeUsers(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $outlet->users;
        
        return $this->collection($collection, new UserTransformer);
    }
    
    public function includePrinters(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $outlet->printers;
        
        return $this->collection($collection, new PrinterTransformer);
    }

}
