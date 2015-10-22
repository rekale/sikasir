<?php

use Illuminate\Database\Seeder;
use Sikasir\Outlet;
use Sikasir\Finances\Income;
use Ramsey\Uuid\Uuid;

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
            foreach(range(1, 5) as $i) {
                
                $outlet->incomes()->save(new Income([
                    'id' => Uuid::uuid4()->toString(),
                    'total' => $fake->numberBetween(1000, 1000000),
                    'note' => $fake->paragraph(),
                ]));
            
            }
                
        });
    }
}
