<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Orders\Order;

class OrderSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        
        foreach (Outlet::all() as $outlet) {
            
            $customers = $outlet->customers;
            $employees = $outlet->employees;
            
            //create order
            $orders = factory(Order::class, 3)->create([
                'outlet_id' => $outlet->id,
                'customer_id' => $customers->random()->id,
                'user_id' => $employees->random()->user->id,
            ]);
            
            //attach items in order
            $stockIds = $outlet->stocks
                            ->random(3)
                            ->lists('id')
                            ->toArray();
            foreach ($orders as $order) {
                $order->stocks()
                    ->attach($stockIds, ['total' => $fake->numberBetween(1, 10)]);
            }
            
            //select random order to void by random employee
            $orders->random()
                ->void()
                ->attach($employees->random()->id, ['note' => $fake->words(3, true)]);
            
        };
        
    }
}
