<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Stocks\Opname;

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
        
        //employees create stock entry and stock out
        $outlets->each(function ($outlet)
        {
            //add stock to outlet
            $products = Product::all();
            foreach ($products as $product) {

                $stock = Stock::create([
                    'outlet_id' => $outlet->id,
                    'product_id' => $product->id,
                ]);

                $variantIds = $stock->product
                                ->variants
                                ->lists('id')
                                ->toArray();
               
                //create its stock_details
                $stock->variants()->attach($variantIds);

            }
            
            $employee = Employee::all()->random();
            $stockdetails = $outlet->stockdetails;
            //create stock entry
            $entry = factory(Entry::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stockdetails from current outlet
            $stockDetailIds = $stockdetails->random(3)
                                        ->lists('id')
                                        ->toArray();
            //add it in stock entry
            $entry->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            
            //create stock out
            $out = factory(Out::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stock from current outlet
            $stockDetailIds = $stockdetails->random(5)
                                        ->lists('id')
                                        ->toArray();
            //add it in stock out
            $out->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            
            //create stock opname
            $opname = factory(Opname::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stock from current outlet
            $stockDetailIds = $stockdetails->random(5)
                                        ->lists('id')
                                        ->toArray();
            //add it in stock opname
            $opname->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            
        });
        
        
    }
}
