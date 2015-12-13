<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Customer;

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
            $customer = factory(Customer::class)->make();
            
            $outlet->customers()->save($customer);

                
        });
        
    }
}
