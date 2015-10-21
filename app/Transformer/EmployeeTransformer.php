<?php

namespace Sikasir\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\User\Employee;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class EmployeeTransformer extends TransformerAbstract
{
    
    public function transform(Employee $employee)
    {
        return [
            'id' => (int) $employee->id,
            'name' => $employee->name,
            'email' => $employee->user->email,
            'address' => $employee->address, 
            'phone'=> $employee->phone, 
            'void_access' => (boolean) $employee->void_access, 
            'icon' => $employee->icon
            
        ];
    }
    
}