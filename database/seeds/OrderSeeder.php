<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Orders\Order;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\Orders\Debt;
use Sikasir\V1\Products\Variant;

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

            $customers= $outlet->company->customers;
            $employees = $outlet->users;
            $tax = $outlet->tax;
            $discounts = $outlet->company->discounts;
            $payments = $outlet->company->payments;

            //create order
            $orders = [];

            foreach (range(1, 100) as $i) {
            	$orders[] = factory(Order::class)->create([
		            			'outlet_id' => $outlet->id,
		            			'customer_id' => $customers->random()->id,
		            			'user_id' => $employees->random()->id,
		            			'payment_id' => $payments->random()->id,
		            			'tax_id' => $tax->id,
		            			'discount_id' => $discounts->random()->id,
            				]);
            }


            foreach ($orders as $order) {

            	$variants = $outlet->variants->load('product')->random(10);

                foreach ($variants as $variant) {
                    $order->variants()->attach(
                        $variant->id,
                        [
                            'total' => $fake->numberBetween(10, 100),
                        	'weight' => $fake->numberBetween(1, 10),
                            'price' =>  $variant->price,
                            'nego' => $fake->numberBetween(1000, 5000),
                            'discount_by_product' => $variant->product->discount_by_product
                        ]
                    );
                }

            }



            //select random order to void by random employee
            foreach (range(1, 5) as $i) {
            	factory(Void::class)->create([
            			'user_id' => $employees->random()->id,
            			'order_id' => $orders[mt_rand(1, 99)]->id
            	]);
            }

            //select random order to void by random employee
            foreach (range(1, 5) as $i) {
            	factory(Debt::class)->create([
            			'order_id' => $orders[mt_rand(1, 99)]->id
            	]);
            }

        };

    }
}
