<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;

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
            $owner->user->assign('cashier');
        });
        
        Employee::all()->each(function ($employee) {
            $employee->user->assign('staff');
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
