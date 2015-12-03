<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->cashierAbilities() as $doThis) {
            \Bouncer::allow('kasir')->to($doThis);   
        }
        foreach ($this->staffAbilities() as $doThis) {
            \Bouncer::allow('staff')->to($doThis);   
        }
        foreach ($this->OwnerAbilities() as $doThis) {
            \Bouncer::allow('owner')->to($doThis);   
        }
        foreach ($this->adminAbilities() as $doThis) {
            \Bouncer::allow('admin')->to($doThis);   
        }
        
        Owner::all()->each(function ($owner) {
            $owner->user->assign('owner');
            $owner->user->assign('staff');
            $owner->user->assign('kasir');
        });
        Employee::all()->each(function ($employee) {
     
            if (rand(0, 1)) {
                $employee->user->assign('staff');
            }
     
            $employee->user->assign('kasir');
        
            
        });
        
    }
    
    public function cashierAbilities()
    {
        return [
            'create-customer',
            'read-customer',
            'update-customer',
            'delete-customer',
            'crud-inventory',
            'view-transaction',
            'crud-kas',
            'crud-orderlist',
            'export-report',
        ];
    }
    
    public function staffAbilities()
    {
        return [
            'create-product',
            'read-product',
            'update-product',
            'delete-product',
            'create-cashier',
            'read-cashier',
            'update-cashier',
            'delete-cashier',
            'void-transaction',
            'crud-struk',
            'read-report',
        ];
    }
    
    public function ownerAbilities()
    {
        return [
            'create-outlet',
            'read-outlet',
            'update-outlet',
            'delete-outlet',
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
