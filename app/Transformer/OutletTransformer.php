<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\Outlet;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutletTransformer extends TransformerAbstract
{
    use \Sikasir\Traits\IdObfuscater;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'employees'
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
            'icon' => $outlet->icon
            
        ];
    }
    
    public function includeEmployees(Outlet $outlet)
    {
        $employees = $outlet->employees;
        
        return $this->collection($employees, new EmployeeTransformer);
    }
    
}
