<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\StockIn;
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
        
        $outlets = Outlet::all();
        $employees = Employee::all();
        
        Stock::all()->each(function ($stock) use ($outlets, $employees) {
        
            $variants = $stock->product->variants;
            $sourceOutlet = $stock->outlet;
            $destOutlet = $outlets->random();
            $employee = $employees->random();
            
            foreach ($variants as $variant) {     
                factory(StockDetail::class)->create([
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockIn::class)->create([
                    'user_id' => $employee->user->id,
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockOut::class)->create([
                    'user_id' => $employee->user->id,
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockTransfer::class)->create([
                    'user_id' => $employee->user->id,
                    'source_outlet_id' => $sourceOutlet->id,
                    'destination_outlet_id' => $destOutlet->id,
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
            }
            
            
            
        });
    }
}
