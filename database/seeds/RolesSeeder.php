<?php

use Illuminate\Database\Seeder;
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
        
        $owner = User::whereName('owner')->first();
        
        $owner->assign('owner');
        
        User::all()->each(function ($employee) {
            $employee->assign('employee');
        });
        
    }

    public function employeeAbilities()
    {
        return [
            'read-specific-outlet',
            'read-specific-staff',
            
            'create-customer',
            'read-customer',
            'update-customer',
            'delete-customer',
            
            'create-tax',
            'read-tax',
            'update-tax',
            'delete-tax',
            
            'create-category',
            'read-category',
            'update-category',
            'delete-category',
            
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
            
            'read-inventory',
            'create-inventory',
            'update-inventory',
            'delete-inventory',
            
            'create-order',
            'read-order',
            'void-order',
            'update-order',
            'delete-order',
            
            'read-report',
            'export-report',
            
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
