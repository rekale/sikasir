<?php

use Illuminate\Database\Seeder;

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
        
        foreach (range(1, 10) as $i) {
            Sikasir\Outlets\Customer::create([
                'name' => $fake->name, 
                'email' => $fake->email, 
                'sex' => $fake->randomElement(['male', 'female']), 
                'phone' => $fake->phoneNumber, 
                'address' => $fake->address, 
                'city' => $fake->city, 
                'pos_code' => $fake->postcode,
            ]);
        }
        
    }
}
