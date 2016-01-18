<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Printer;
use Sikasir\V1\Outlets\Outlet;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outlet::all()->each(function ($outlet) {
            
            $printers = factory(Printer::class, 3)->create([
                'outlet_id' => $outlet->id,
            ]);
            
            
        });
    }
}
