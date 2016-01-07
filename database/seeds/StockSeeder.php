<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Products\Product;

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
               
                //crate its stock_details
                $stock->variants()->attach($variantIds);

            }
            
            $employee = Employee::all()->random();
            
            //create stock entry
            $entry = factory(Entry::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stockdetails from current outlet
            $stockDetailIds = $outlet->stockdetails
                                    ->random(3)
                                    ->lists('id')
                                    ->toArray();
            //add it in stock entry
            $entry->stockdetails()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            
            //create stock out
            $out = factory(Out::class)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            //get random stock from current outlet
            $stockDetailIds = $outlet->stockdetails
                                    ->random(5)
                                    ->lists('id')
                                    ->toArray();
            //add it in stock entry
            $out->stockdetails()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            
        });
        
        
    }
}
