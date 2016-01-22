<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Admin;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Transactions\Payment;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $admin = new User([
            'name' => 'admin',
            'email' => 'admin@sikasir.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        
        $adminuser = factory(Admin::class)->create([
            'name' => $admin->name,
        ]);
        
        $adminuser->user()->save($admin);
        
        $user = new User([
            'name' => 'owner',
            'email' => 'owner@sikasir.com',
            'password' => bcrypt('owner'),
            'remember_token' => str_random(10),
        ]);
        
        $owner = factory(Owner::class)->create([
            'name' => $user->name, 
        ]);
        
        $owner->user()->save($user);
        
        $owner->app()->save(new \Sikasir\V1\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));
        
        
        $userEmployees = factory(User::class, 3)->make([
            'password' => bcrypt('12345'),
        ]);

        foreach ($userEmployees as $user) {
            $employee = factory(Employee::class)->create([
                 'owner_id' => $owner->id,
                 'name' => $user->name,
            ]);
            
            $employee->user()->save($user);
        }
        
        $this->createOutlets();
        
    }
    
    public function createOutlets()
    {
        $businessField[] = BusinessField::create([
            'name' => 'F&B',
        ])->id;
        $businessField[] = BusinessField::create([
            'name' => 'Retail',
        ])->id;
        $businessField[] = BusinessField::create([
            'name' => 'Komoditas',
        ])->id;
        
        
        //create an outlet for every owner
        Owner::all()->each(function($owner) use ($businessField){
                
                //create tax for each owner
                $taxes = factory(Tax::class, 3)->create([
                    'owner_id' => $owner->id,
                ]);
                
                //create discount
                factory(Discount::class, 3)->create([
                    'owner_id' => $owner->id,
                ]);
                
                //create payment
                factory(Payment::class)->create([
                    'owner_id' => $owner->id,
                    'name' => 'Tunai',
                ]);
                
                //create payment
                factory(Payment::class)->create([
                    'owner_id' => $owner->id,
                    'name' => 'Kredit',
                ]);
                
                //create outlet for each owner and add tax
                $outlets = factory(Outlet::class, 3)->create([
                    'owner_id' => $owner->id,
                    'tax_id' => $taxes->random()->id,
                    'business_field_id' => $businessField[mt_rand(0, 2)],
                ]);
                
                //lists created employees id
                $employees = $owner->employees->lists('id');
               
                //add employees to every outlets
                foreach ($outlets as $outlet) {
                    $outlet->employees()->attach($employees->toArray());
                }
        });
    }
}
