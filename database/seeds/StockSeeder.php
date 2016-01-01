<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\Outlet;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $outlet = Outlet::all();
        
        //employees create stock entry and stock out
        $outlet->each(function ($outlet)
        {
            $employee = Employee::all()->random();
            
            //create stock entry
            $entry = factory(Entry::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stock from current outlet
            $stockIds = $outlet->stocks->random(5)->lists('id')->toArray();
            //add it in stock entry
            $entry->stocks()->attach($stockIds, ['total' => rand(1, 50)]);
            
            //create stock out
            $out = factory(Out::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stock from current outlet
            $stockIds = $outlet->stocks->random(5)->lists('id')->toArray();
            //add it in stock entry
            $out->stocks()->attach($stockIds, ['total' => rand(1, 50)]);
            
        });
        
        
    }
}
