<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Finances\Income;
use Sikasir\V1\Finances\Outcome;

class FinanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        
        Outlet::all()->each(function ($outlet) use ($fake)
        {
            foreach(range(1, 20) as $i) {
                
                $outlet->incomes()->save(new Income([
                    'total' => $fake->numberBetween(1000, 1000000),
                    'note' => $fake->paragraph(),
                ]));
            
            }
                
        });
        
        Outlet::all()->each(function ($outlet) use ($fake)
        {
            foreach(range(1, 20) as $i) {
                
                $outlet->outcomes()->save(new Outcome([
                    'total' => $fake->numberBetween(1000, 1000000),
                    'note' => $fake->paragraph(),
                ]));
            
            }
                
        });
    }
}
