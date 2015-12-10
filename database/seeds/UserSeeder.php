<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\Employee;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();

        $user = User::create([
            'name' => 'owner',
            'email' => 'owner@sikasir.com',
            'password' => bcrypt('owner'),
            'remember_token' => str_random(10),
        ]);
        
        $owner = $user->owner()->save( new Owner([
            'name' => 'owner', 
            'business_name' => $fake->company, 
            'phone' => $fake->phoneNumber,
            'address' => $fake->address,
            'icon' => $fake->imageUrl(), 
            'active' => true,
        ]));

        $owner->app()->save(new \Sikasir\V1\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));
        
        foreach(range(1, 5) as $i) {
           
            $owner->employees()->save(factory(Employee::class)->make([
                'owner_id' => $owner->id,
            ]));
            
            $owner->cashiers()->save(factory(Cashier::class)->make([
                'owner_id' => $owner->id,
            ]));

        }

    }
}
