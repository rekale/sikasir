<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\StockIn;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\Stocks\StockTransfer;
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
        
        Stock::all()->each(function ($stock) use ($outlet) {
        
            $variants = $stock->product->variants;
            $sourceOutlet = $stock->outlet;
            $destOutlet = $outlet->random();
            
            foreach ($variants as $variant) {     
                factory(StockDetail::class)->create([
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockIn::class)->create([
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockOut::class)->create([
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
                
                factory(StockTransfer::class)->create([
                    'source_outlet_id' => $sourceOutlet->id,
                    'destination_outlet_id' => $destOutlet->id,
                    'stock_id' => $stock->id,
                    'variant_id' => $variant->id,
                ]);
            }
            
            
            
        });
    }
}
