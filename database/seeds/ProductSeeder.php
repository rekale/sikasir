<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;
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
        
        Owner::all()->each(function ($owner) use ($fake)
        {
            foreach (range(1, 2) as $i) {
                $owner->categories()->save(new Category([
                    'name' => $fake->word,
                ]));
            }
        });
        
        Category::all()->each(function ($category) use ($fake) {
        
            foreach (range(1, 2) as $i) {
                $category->products()->save(new Product([
                    'name' => $fake->word, 
                    'description' => $fake->words(3, true), 
                    'barcode' => $fake->word, 
                    'show' => $fake->boolean(), 
                ]));
            }
            
        });
        
         //create variant for each 
        Product::all()->each(function ($product) use ($fake)
        {
            foreach (range(1, 2) as $i) {
                $product->variants()->save(new Variant([
                    'name' => $fake->word, 
                    'code' => $fake->numerify(), 
                    'price' => $fake->numberBetween(1000, 100000), 
                    'unit' => $fake->word,
                ]));
            }
            
            $outlet = Outlet::all()->random();
            
            $product->outlets()->attach($outlet->id);
            
        });
        
        
    }
}
