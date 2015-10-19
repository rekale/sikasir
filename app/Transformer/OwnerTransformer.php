<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\User\Owner;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OwnerTransformer extends TransformerAbstract
{
   
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'outlets',
        'employees',
    ]; 
    
    public function transform(Owner $owner)
    {
        return [
            'full_name' => $owner->full_name, 
            'business_name' => $owner->business_name, 
            'phone' => $owner->phone, 
            'address' => $owner->address, 
            'icon' => $owner->icon, 
            'active' => (boolean) $owner->active,
        ];
    }
    
    public function includeOutlets(Owner $owner)
    {
        $outlets = $owner->outlets;
        
        return $this->collection($outlets, new OutletTransformer);
    }
    
    public function includeEmployees(Owner $owner)
    {
        $employees = $owner->employees;
        
        return $this->collection($employees, new EmployeeTransformer);
    }
    
}
