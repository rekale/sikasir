<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
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
        
        $employees = Employee::all();
        
        //employees create stock entry and stock out
        $employees->each(function ($employee)
        {
            factory(StockEntry::class, 2)->create([
                'user_id' => $employee->user->id,
            ]);
            
            factory(StockOut::class, 2)->create([
                'user_id' => $employee->user->id,
            ]);
            
        });
        
        
        //stock entry increase some variant stock's total
        
        StockEntry::all()->each(function($entry)
        {
            
            $outlet = Outlet::all()->random();
            
            $stockIds = $outlet->stocks->random(5)->lists('id');
            
            $entry->stocks()->attach($stockIds->toArray(), ['total' => rand(1, 50)]);
            
        });
        
        StockOut::all()->each(function($out)
        {
            
            $outlet = Outlet::all()->random();
            
            $stockIds = $outlet->stocks->lists('id');
            
            $out->stocks()->attach($stockIds->toArray(), ['total' => rand(1, 10)]);
            
        });
        
    }
}
