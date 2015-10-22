<?php

use Illuminate\Database\Seeder;
use Sikasir\User\User;
use Ramsey\Uuid\Uuid;

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
            $id =  Uuid::uuid4()->toString();
            
            $owner = Sikasir\User\Owner::create([
                'id' => $id,
                'full_name' => $name,
                'business_name' => $fake->word,
                'phone' => $fake->phoneNumber,
                'address' => $fake->address,
                'icon' => $fake->imageUrl(300, 200, 'people'),
                'active' => $fake->boolean(),
            ]);
            
            $owner->user()->save(new User([
                'id' => $id,
                'name' => $name,
                'email' => $fake->email,
                'password' => bcrypt('owner'),
            ]));
            
            $owner->app()->save(new \Sikasir\User\App([
                'username' => $i === 1 ? 'owner':$name . rand(1, 10),
                'password' => bcrypt('owner'),
            ]));
        }
        
        foreach(range(1, 30) as $i) {
            $employeeName = $fake->name;
            $id =  Uuid::uuid4()->toString();
            
            $employee = Sikasir\User\Employee::create([
                'id' => $id,
                'name' => $employeeName,
                'title' => $fake->randomElement(['staff', 'kasir']),
                'phone' => $fake->phoneNumber,
                'address' => $fake->address,
                'icon' => $fake->imageUrl(300, 200, 'people'),
                'void_access' => $fake->boolean(),
            ]);
           
            $employee->user()->save(new User([
                'id' => $id,
                'name' => $employeeName,
                'email' => $fake->email,
                'password' => bcrypt('12345'),
            ]));
        }
        
    }
}
