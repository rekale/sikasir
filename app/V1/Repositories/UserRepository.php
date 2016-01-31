<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\User;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;

/**
 * Description of EmployeeRepository
 *
 * @author rekale
 */
class UserRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;
    
    public function __construct(User $model) 
    {
        parent::__construct($model);
    }
    
    public function saveForOwner(array $data, $companyId) 
    {
        \DB::transaction(function () use ($data, $companyId) {
            
            $data['password'] = bcrypt($data['password']);
            
            $user = new User($data);

            $data['company_id'] = $companyId;

            $this->addPrivileges($user, $data['privileges']);

            $user->outlets()->attach($data['outlet_id']);

            
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
            
            'create-inventory',
            'read-inventory',
            'update-inventory',
            'delete-inventory',
        ];
    }
    
    public function doOrderAbilties()
    {
        return [
            'create-order',
            'read-order',
            'void-order',
            'update-order',
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
