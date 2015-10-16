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
        
        foreach (range(1, 5) as $i) {
            $name = $fake->name;
           
            $owner = Sikasir\User\Owner::create([
                'full_name' => $name,
                'business_name' => $fake->word,
                'phone' => $fake->phoneNumber,
                'address' => $fake->address,
                'icon' => $fake->imageUrl(300, 200, 'people'),
                'active' => $fake->boolean(),
            ]);
           
            $owner->user()->save(new User([
                'name' => $name,
                'email' => $fake->email,
                'password' => bcrypt('owner'),
            ]));
            
            $employeeName = $fake->name;
           
            $employee = Sikasir\User\Employee::create([
                'name' => $employeeName,
                'phone' => $fake->phoneNumber,
                'address' => $fake->address,
                'icon' => $fake->imageUrl(300, 200, 'people'),
                'void_access' => $fake->boolean(),
            ]);
           
            $employee->user()->save(new User([
                'name' => $employeeName,
                'email' => $fake->email,
                'password' => bcrypt('employee'),
            ]));
            
        }
        
    }
}
