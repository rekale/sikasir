<?php

use Illuminate\Database\Seeder;
use Sikasir\Outlets\Outlet;
use Sikasir\Outlets\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        
        Outlet::all()->each(function ($outlet) use ($fake)
        {
            foreach(range(1, 10) as $i) {
                
                $outlet->customers()->save(new Customer([
                    'name' => $fake->name,
                    'email' => $fake->email, 
                    'sex' => $fake->randomElement(['male', 'female']), 
                    'phone' => $fake->phoneNumber, 
                    'address' => $fake->address, 
                    'city' => $fake->city, 
                    'pos_code' => $fake->postcode,
                ]));
            
            }
                
        });
        
    }
}
