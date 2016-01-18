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
        foreach ($this->cashierAbilities() as $doThis) {
            \Bouncer::allow('cashier')->to($doThis);
        }
        foreach ($this->employeeAbilities() as $doThis) {
            \Bouncer::allow('staff')->to($doThis);
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
            $owner->user->assign('staff');
            $owner->user->assign('cashier');
            
            $owner->user->allow($this->doProductAbilities());
            $owner->user->allow($this->doOrderAbilties());
            $owner->user->allow($this->doReportAbilties());
            $owner->user->allow($this->doBillingAbilties());
        });
        
        Employee::all()->each(function ($employee) {
            $employee->user->assign('staff');
            $employee->user->assign('cashier');
            
            $employee->user->allow($this->doProductAbilities());
            $employee->user->allow($this->doOrderAbilties());
            $employee->user->allow($this->doReportAbilties());
            $employee->user->allow($this->doBillingAbilties());
        });
        
        Cashier::all()->each(function ($cashier) {
            $cashier->user->assign('cashier');
        });

    }

    public function cashierAbilities()
    {
        return [
            'create-customer',
            'read-customer',
            'update-customer',
            'delete-customer',
            
            'read-specific-outlet',
            'read-specific-owner',
            
            'create-order',
            'update-order',
            'delete-order',
            
            'crud-inventory',
            'view-transaction',
            'crud-kas',
            'crud-orderlist',
            'export-report',
        ];
    }

    public function employeeAbilities()
    {
        return [
            
            'create-cashier',
            'read-cashier',
            'update-cashier',
            'delete-cashier',
            
        ];
    }

    public function ownerAbilities()
    {
        return [
            'create-outlet',
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
            'void-transaction',
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
