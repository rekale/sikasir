<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;

/**
 * Description of EmployeeRepository
 *
 * @author rekale
 */
class EmployeeRepository extends Repository implements BelongsToOwnerRepo
{
    public function __construct(Employee $model) 
    {
        parent::__construct($model);
    }

    public function saveForOwner(array $data, Owner $owner) 
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        
        $data['user_id'] = $user->id;
        $data['owner_id'] = $owner->id;
        
        $employee = Employee::create($data);
        
        $employee->outlets()->attach($data['outlet_id']);
       
    }

    public function destroyForOwner($id, Owner $owner) 
    {
        $owner->employees()->findOrFail($id);
        
        $this->destroy($id);
    }

    public function findForOwner($id, Owner $owner) 
    {
        return $owner->employees()->findOrFail($id);
    }

    public function getPaginatedForOwner(Owner $owner)
    {
        return $owner->employees()->paginate();
    }

    public function updateForOwner($id, array $data, Owner $owner) 
    {
        $employee = $owner->employees()->findOrFail($id);
        
        $employee->update($data);
        
        $employee->outlets()->sync($data['outlet_id']);
        
    }

}