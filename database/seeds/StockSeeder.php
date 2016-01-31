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
use Sikasir\V1\User\User;

use Illuminate\Support\Collection;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $outlets = Outlet::with(['products.variants'])->get();
        
        //employees create stock entry, stock out, opname and purchase order
        
        $outlets->each(function (Outlet $outlet)
        {
            
            $variants = new Collection;
            
            foreach ($outlet->products as $product) {
                
                foreach($product->variants as $variant) {
                    $variants->push($variant);
                }
                
            }
            
            $suppliers = Supplier::whereCompanyId($outlet->company_id)->get();
            $employees = $outlet->users;
            
            /* --STOCK ENTRY-- */
            
            //create stock entry
            $entries = factory(Entry::class, 3)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock entry
            foreach ($entries as $entry) {
                $entry->variants()->attach(
                    $variants->random(3)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --STOCK OUT-- */
            
            //create stock out
            $outs = factory(Out::class, 3)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock out
            foreach ($outs as $out) {
                $out->variants()->attach(
                    $variants->random(3)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --OPNAME-- */
            
            //create stock opname
            $opnames = factory(Opname::class, 3)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock opname
            foreach ($opnames as $opname) {
                $opname->variants()->attach(
                    $variants->random(3)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --PURCHASE ORDER-- */
            
            //create stock opname
            $purchases = factory(PurchaseOrder::class, 3)->create([
                'supplier_id' => $suppliers->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in purchase order
            foreach ($purchases as $purchase) {
                $purchase->variants()->attach(
                     $variants->random(3)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            
        });
        
        
    }
}
