<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Company;
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
        
        $company = Company::findOrFail(1);
        
            $customer = factory(Customer::class, 300)->make();
            
            $company->customers()->saveMany($customer);

                
        
    }
}
