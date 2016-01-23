<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Suppliers\Supplier;

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
        
        //employees create stock entry, stock out, opname and purchase order
        
        $outlets->each(function ($outlet)
        {
            
            /* --STOCK-- */
            
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
            
            
            $employee = Employee::all('id')->random();
            $supplier = Supplier::all('id')->random();
            $stockdetails = $outlet->stockdetails;
            $stockDetailIds = $stockdetails->random(5)
                                        ->lists('id')
                                        ->toArray();
            
            /* --STOCK ENTRY-- */
            
            //create stock entry
            $entries = factory(Entry::class, 3)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock entry
            foreach ($entries as $entry) {
                $entry->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            }
            
            /* --STOCK OUT-- */
            
            //create stock out
            $outs = factory(Out::class, 3)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock out
            foreach ($outs as $out) {
                $out->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            }
            
            /* --OPNAME-- */
            
            //create stock opname
            $opnames = factory(Opname::class, 3)->create([
                'user_id' => $employee->user->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock opname
            foreach ($opnames as $opname) {
                $opname->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            }
            
            /* --PURCHASE ORDER-- */
            
            //create stock opname
            $purchases = factory(PurchaseOrder::class, 3)->create([
                'supplier_id' => $supplier->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in purchase order
            foreach ($purchases as $purchase) {
                $purchase->items()->attach($stockDetailIds, ['total' => rand(1, 50)]);
            }
            
            
        });
        
        
    }
}
