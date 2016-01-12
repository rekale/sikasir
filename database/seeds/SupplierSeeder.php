<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Owner;
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
        Owner::all()->each(function ($owner) {
        
            $suppliers = factory(Supplier::class, 3)->make();
            
            $owner->suppliers()->saveMany($suppliers);
            
        });
    }
}
