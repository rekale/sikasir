<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Cashier;

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

        $owner = Sikasir\V1\User\Owner::create([
               'full_name' => 'owner',
               'business_name' => $fake->word,
               'phone' => $fake->phoneNumber,
               'address' => $fake->address,
               'icon' => $fake->imageUrl(300, 200, 'people'),
               'active' => true,
           ]);

        $owner->user()->save(new User([
            'name' => 'owner',
            'email' => 'owner@sikasir.com',
            'password' => bcrypt('owner'),
        ]));

        $owner->app()->save(new \Sikasir\V1\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));
        
        foreach(range(1, 10) as $i) {
            $employeeName = $fake->name;

            $owner->employees()->save(
                new Sikasir\V1\User\Employee([
                    'name' => $employeeName,
                    'title' => $fake->randomElement(['staff', 'kasir']),
                    'gender' => $fake->randomElement(['pria', 'wanita']),
                    'phone' => $fake->phoneNumber,
                    'address' => $fake->address,
                    'icon' => $fake->imageUrl(300, 200, 'people'),
                    'void_access' => $fake->boolean(),
                ])
            );
            
            $owner->cashiers()->save(factory(Cashier::class)->make());

        }

        Sikasir\V1\User\Employee::all()->each(function ($employee) use($fake) {

            $employee->user()->save(new User([
                'name' => $employee->name,
                'email' => $fake->email,
                'password' => bcrypt('12345'),
            ]));

        });
        
        Cashier::all()->each(function ($cashier) use($fake) {

            $cashier->user()->save(new User([
                'name' => $cashier->name,
                'email' => $fake->email,
                'password' => bcrypt('12345'),
            ]));

        });

    }
}
