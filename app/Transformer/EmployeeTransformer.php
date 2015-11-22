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
    use \Sikasir\Traits\IdObfuscater;

    public function transform(Employee $employee)
    {
        return [
            'id' => $this->encode($employee->id),
            'name' => $employee->name,
            'gender' => $employee->gender,
            'title' => $employee->title,
            'email' => $employee->user->email,
            'address' => $employee->address,
            'phone'=> $employee->phone,
            'void_access' => (boolean) $employee->void_access,
            'icon' => $employee->icon

        ];
    }

}
