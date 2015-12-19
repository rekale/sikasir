<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Owner;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OwnerTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'outlets',
        'employees',
        'cashiers',
        'products',
        'taxes',
    ]; 
    
    public function transform(Owner $owner)
    {
        return [
            'id' => $this->encode($owner->id),
            'email' => $owner->user->email,
            'name' => $owner->name, 
            'business_name' => $owner->business_name, 
            'phone' => $owner->phone, 
            'address' => $owner->address, 
            'icon' => $owner->icon, 
            'active' => (boolean) $owner->active,
        ];
    }
    
    public function includeOutlets(Owner $owner, ParamBag $params = null)
    {
        
        $collection = $this->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->setBuilder($owner->outlets())
                            ->result();
        
        return $this->collection($collection, new OutletTransformer);
    }
    
    public function includeEmployees(Owner $owner, ParamBag $params = null)
    {
        $collection = $this->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->setBuilder($owner->employees())
                            ->result();
        
        return $this->collection($collection, new EmployeeTransformer);
    }
    
    
    public function includeProducts(Owner $owner, ParamBag $params = null)
    {
        $collection = $this->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->setBuilder($owner->products())
                            ->result();
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    public function includeTaxes(Owner $owner, ParamBag $params)
    {
        $collection = $this->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->setBuilder($owner->taxes())
                            ->result();
        
        return $this->collection($collection, new TaxTransformer);
    }
    
}
