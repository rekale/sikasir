<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Suppliers\Supplier;

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
            
            $variants = $outlet->variants;
            
            
            $suppliers = Supplier::whereCompanyId($outlet->company_id)->get();
            $employees = $outlet->users;
            
            /* --STOCK ENTRY-- */
            
            //create stock entry
            $entries = factory(Entry::class, 50)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock entry
            foreach ($entries as $entry) {
                $entry->variants()->attach(
                    $variants->random(10)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --STOCK OUT-- */
            
            //create stock out
            $outs = factory(Out::class, 50)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock out
            foreach ($outs as $out) {
                $out->variants()->attach(
                    $variants->random(10)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --OPNAME-- */
            
            //create stock opname
            $opnames = factory(Opname::class, 50)->create([
                'user_id' => $employees->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in stock opname
            foreach ($opnames as $opname) {
                $opname->variants()->attach(
                    $variants->random(10)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            /* --PURCHASE ORDER-- */
            
            //create stock opname
            $purchases = factory(PurchaseOrder::class, 50)->create([
                'supplier_id' => $suppliers->random()->id,
                'outlet_id' => $outlet->id,
            ]);
            
            //add it in purchase order
            foreach ($purchases as $purchase) {
                $purchase->variants()->attach(
                     $variants->random(10)->lists('id')->toArray(), 
                    ['total' => rand(1, 50)]
                );
            }
            
            
        });
        
        
    }
}
