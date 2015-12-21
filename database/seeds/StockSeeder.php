<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\Stocks\StockTransfer;
use Sikasir\V1\Outlets\Outlet;
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
        
        Stock::all()->each(function ($stock){
        
            $variants = $stock->product->variants;
            
            foreach ($variants as $variant) {     
                factory(StockDetail::class)->create([
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
            }
             
        });
        
        
        $employees = Employee::all();
        
        StockDetail::all()->each(function($stockDetail) use ($employees) {
        
            $user = $employees->random()->user;
            
            factory(StockEntry::class, 3)->create([
                'user_id' => $user->id,
                'stock_detail_id' => $stockDetail->id,
            ]);

            factory(StockOut::class, 3)->create([
                'user_id' => $user->id,
                'stock_detail_id' => $stockDetail->id,
            ]);
                
            
        });
        
        
    }
}
