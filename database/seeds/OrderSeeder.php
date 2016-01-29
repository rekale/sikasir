<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Products\Product;

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
            $tax = $outlet->tax;
            $discounts = $outlet->owner->discounts;
            $payments = $outlet->owner->payments;
            
            //create order
            $orders = factory(Order::class, 3)->create([
                'outlet_id' => $outlet->id,
                'customer_id' => $customers->random()->id,
                'user_id' => $employees->random()->user->id,
                'payment_id' => $payments->random()->id,
                'tax_id' => $tax->id,
                'discount_id' => $discounts->random()->id,
            ]);
            
            
            $productIds = $outlet->products()->lists('id')->toArray();
            //attach items in order
            $variantIds = Product::whereIn('product_id', $productIds)
                            ->get()
                            ->random(3)
                            ->lists('id')
                            ->toArray();
            
            foreach ($orders as $order) {
                $order->products()->attach($variantIds, ['total' => $fake->numberBetween(1, 10)]);
            }
            
            //select random order to void by random employee
            $orderVoided = $orders->random();
            
            $orderVoided->void = true;
            $orderVoided->void_user_id = $employees->random()->user->id;
            $orderVoided->void_note = $fake->words(3, true);
            $orderVoided->save();
            
        };
        
    }
}
