<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();
        //create product category
        $owners = Owner::all();
        
        $owners->each(function ($owner)
        {
            $categories = $owner->categories()->saveMany(
                factory(Category::class, 3)->make()
            );
            
            $outlets = $owner->outlets;
            
            foreach (range(0, 2) as $i) {
                
                $products = factory(Product::class, 3)->create([
                    'category_id' => $categories[$i]->id,
                    'outlet_id' => $outlets[$i]->id,
                ]);
                
                //make variant /subproduct
                foreach ($products as $product) {
                    $product->variants()->saveMany(
                        factory(Product::class, 3)->make([
                            'category_id' => $product->category_id,
                        ])
                    );
                }
            }
            
            
        });
        
    }
}
