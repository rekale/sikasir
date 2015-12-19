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
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $owner->outlets()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new OutletTransformer);
    }
    
    public function includeEmployees(Owner $owner, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $owner->employees()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new EmployeeTransformer);
    }
    
    
    public function includeProducts(Owner $owner, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $owner->products()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    public function includeTaxes(Owner $owner, ParamBag $params)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $owner->taxes()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new TaxTransformer);
    }
    
}
