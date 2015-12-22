<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\User\Employee;

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
        
        Stock::all()->each(function($stock) use ($employees) {
        
            $user = $employees->random()->user;
            
            factory(StockEntry::class, 3)->create([
                'user_id' => $user->id,
                'stock_id' => $stock->id,
            ]);

            factory(StockOut::class, 3)->create([
                'user_id' => $user->id,
                'stock_id' => $stock->id,
            ]);
                
            
        });
        
        
    }
}
