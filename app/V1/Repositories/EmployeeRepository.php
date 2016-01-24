<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\User;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;

/**
 * Description of EmployeeRepository
 *
 * @author rekale
 */
class EmployeeRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;
    
    public function __construct(Employee $model) 
    {
        parent::__construct($model);
    }

    public function saveForOwner(array $data, $ownerId) 
    {
        \DB::transaction(function () use ($data, $ownerId) {
            
            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $data['owner_id'] = $ownerId;

            $employee = Employee::create($data);

            $employee->user()->save($user);

            $this->addPrivileges($employee->user, $data['privileges']);

            $employee->outlets()->attach($data['outlet_id']);

            
        });
               
    }
   
    private function addPrivileges(User $user, $privileges)
    {
        if (in_array( 1, $privileges)) {
            $user->allow($this->doProductAbilities());
        }
        if (in_array( 2, $privileges)) {
            $user->allow($this->doOrderAbilties());
        }
        if (in_array( 3, $privileges)) {
            $user->allow($this->doReportAbilties());
        }
        if (in_array( 4, $privileges)) {
            $user->allow($this->doBillingAbilties());
        }
    }
    
    public function doProductAbilities()
    {
        return [
            'create-product',
            'read-product',
            'update-product',
            'delete-product',
            
            'read-stock',
            'create-stock',
            'delete-stock',
            
            'create-stock-entry',
            'read-stock-entry',
            'delete-stock-entry',
            
        ];
    }
    
    public function doOrderAbilties()
    {
        return [
            'read-order',
        ];
    }
    
    public function doReportAbilties()
    {
        return [
            'read-report',
        ];
    }
    
    public function doBillingAbilties()
    {
        return [
            'read-billing',
            'create-billing',
            'update-billing',
            'delete-billing',
        ];
    }

}
