<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Orders\Void;

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
            
            $customers = $outlet->company->customers;
            $employees = $outlet->users;
            $tax = $outlet->tax;
            $discounts = $outlet->company->discounts;
            $payments = $outlet->company->payments;
            
            //create order
            $orders = factory(Order::class, 3)->create([
                'outlet_id' => $outlet->id,
                'customer_id' => $customers->random()->id,
                'user_id' => $employees->random()->id,
                'payment_id' => $payments->random()->id,
                'tax_id' => $tax->id,
                'discount_id' => $discounts->random()->id,
            ]);
            
            
            $variantIds = $outlet->variants->random(3)->lists('id')->toArray(); 
            
            foreach ($orders as $order) {
                $order->variants()->attach(
                    $variantIds, 
                    [
                        'total' => $fake->numberBetween(1, 10), 
                        'nego' => 0,
                    ]
                    );
            }
            
            //select random order to void by random employee
            factory(Void::class)->create([
                'user_id' => $employees->random()->id,
                'order_id' => $orders->random()->id
            ]);
           
        };
        
    }
}
