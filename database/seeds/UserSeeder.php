<?php

use Illuminate\Database\Seeder;
use Sikasir\User\User;

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

        $owner = Sikasir\User\Owner::create([
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

        $owner->app()->save(new \Sikasir\User\App([
            'username' => 'owner',
            'password' => bcrypt('owner'),
        ]));

        foreach(range(1, 10) as $i) {
            $employeeName = $fake->name;
            
            $owner->employees()->save(
                new Sikasir\User\Employee([
                    'name' => $employeeName,
                    'title' => $fake->randomElement(['staff', 'kasir']),
                    'phone' => $fake->phoneNumber,
                    'address' => $fake->address,
                    'icon' => $fake->imageUrl(300, 200, 'people'),
                    'void_access' => $fake->boolean(),
                ])
            );
            
        }
        
        Sikasir\User\Employee::all()->each(function ($employee) use($fake) {
                
            $employee->user()->save(new User([
                'name' => $employee->name,
                'email' => $fake->email,
                'password' => bcrypt('12345'),
            ]));
   
        });

    }
}
