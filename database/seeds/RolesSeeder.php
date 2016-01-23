<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->employeeAbilities() as $doThis) {
            \Bouncer::allow('employee')->to($doThis);
        }
        foreach ($this->OwnerAbilities() as $doThis) {
            \Bouncer::allow('owner')->to($doThis);
        }
        foreach ($this->adminAbilities() as $doThis) {
            \Bouncer::allow('admin')->to($doThis);
        }
        
        $user = User::whereName('admin')->get();
        
        $user[0]->assign('admin');
        
        Owner::all()->each(function ($owner) {
            $owner->user->assign('owner');
            $owner->user->assign('employee');
            
        });
        
        Employee::all()->each(function ($employee) {
            $employee->user->assign('employee');
        });
        
    }

    public function employeeAbilities()
    {
        return [
            'create-customer',
            'read-customer',
            'update-customer',
            'delete-customer',
            
            'create-supplier',
            'read-supplier',
            'update-supplier',
            'delete-supplier',
            
            'create-cashier',
            'read-cashier',
            'update-cashier',
            'delete-cashier',
            
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
            
            'create-order',
            'void-order',
            'update-order',
            'delete-order',
            
        ];
    }

    public function ownerAbilities()
    {
        return [
            'create-outlet',
            'update-outlet',
            'delete-outlet',
            'read-outlet',
            
            'create-staff',
            'read-staff',
            'update-staff',
            'delete-staff',
            
            'create-mobileaccount',
            'read-mobileaccount',
            'update-mobileaccount',
            'delete-mobileaccount',
            
            'crud-billing',
        ];
    }

    public function adminAbilities()
    {
        return [
            'create-owner',
            'read-owner',
            'update-owner',
            'delete-owner',
        ];
    }
    
}
