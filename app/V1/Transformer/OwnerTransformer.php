<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Owner;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OwnerTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater;
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
            'id' => $this->encode($owner->id),
            'email' => $owner->user->email,
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
