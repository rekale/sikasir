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
            
        	//manager default, kasisr default termasuk manager default
            'edit-supplier',
        	'edit-settings', //tax, discount, payment, printer
            'edit-cashier',
        	'edit-employee',
        		
        	//manager optional, buat bikin kategori produk dan variant
            'edit-product', //1
        	'report-order',//2
        	'void-order',//5
        	'read-report',//3
        	'billing',//4
        		
            //kasir default
            'read-outlet',
        	'read-customer',
        	'edit-customer',
        	'read-inventory',
        	'read-supplier',
        	'read-settings', //tax, discount, payment, printer
        	'read-cashier',
        	'read-employee', 
        	'read-product',
            'read-inventory',
        	'edit-inventory',
        	'read-order',
        	'edit-order',
            
        ];
    }

    public function ownerAbilities()
    {
        return [
            'edit-outlet',
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
