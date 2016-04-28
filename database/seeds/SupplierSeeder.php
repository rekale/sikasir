<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Company;
use Sikasir\V1\Suppliers\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$company = Company::findOrFail(1);
    	
        
            $suppliers = factory(Supplier::class, 50)->make();
            
            $company->suppliers()->saveMany($suppliers);
            
        
    }
}
