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

        $owners = User::whereTitle('owner')->get();

        foreach ($owners as $owner) {
        	$owner->assign('owner');
        }
        
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

            //kasir default
            'read-outlet',
        	'read-customer',
        	'edit-customer',
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
        	//optional for manager, default for owner
        	'edit-product',
       		'report-order',
       		'read-report',
       		'billing',
       		'void-order',
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
