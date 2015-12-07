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

        $owner = factory(Owner::class)->create([
            'name' => 'owner',
        ]);

        $owner->app()->save(new \Sikasir\V1\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));
        
        foreach(range(1, 10) as $i) {
           
            $owner->employees()->save(factory(Employee::class)->make());
            
            $owner->cashiers()->save(factory(Cashier::class)->make());

        }

    }
}
