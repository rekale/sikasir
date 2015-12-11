<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Outlet;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@sikasir.com',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        
        $user = User::create([
            'name' => 'owner',
            'email' => 'owner@sikasir.com',
            'password' => bcrypt('owner'),
            'remember_token' => str_random(10),
        ]);
        
        $owner = factory(Owner::class)->create([
            'user_id' => $user->id,
            'name' => $user->name, 
        ]);
        

        $owner->app()->save(new \Sikasir\V1\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));
        
        
        $userEmployees = factory(User::class, 3)->create();

        foreach ($userEmployees as $user) {
             $owner->employees()->save(factory(Employee::class)->make([
                'user_id' => $user->id, 
                'name' => $user->name,
            ]));
        }
        
        $this->createOutlets();
           
        $userCashiers = factory(User::class, 3)->create();
        
        $outlets = $owner->outlets()->lists('id');
        
        foreach ($userCashiers as $user) {
        
            $owner->cashiers()->save(factory(Cashier::class)->make([
                'user_id' => $user->id, 
                'outlet_id' => $outlets[mt_rand(0, count($outlets)-1)],
                'name' => $user->name,
            ]));
        
            
        }
        

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

                $outlets = factory(Outlet::class, 3)->make([
                    'owner_id' => $owner->id,
                    'business_field_id' => $businessField[mt_rand(0, 2)],
                ]);
                
                $owner->outlets()->saveMany($outlets);
                
                $employees = $owner->employees->lists('id');
                
                $owner->outlets->each(function ($outlet) use ($employees) {
                    
                    $outlet->employees()->attach($employees->toArray());
                    
                });
        });
    }
}
