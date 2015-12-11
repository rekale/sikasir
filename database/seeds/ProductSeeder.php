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
        $owners = Owner::all();
        $owners->each(function ($owner)
        {
            $categories = factory(Category::class, 3)->make();
            
            $owner->categories()->saveMany($categories);
            
            
        });
        
        Category::all()->each(function ($category) {
            
            $products = factory(Product::class, 3)->make();
            
            $category->products()->saveMany($products);
            
        });
        
         //create variant for each 
        Product::all()->each(function ($product)
        {
            $variants = factory(Variant::class, 3)->make();
            
            $product->variants()->saveMany($variants);
            
            
        });
        
        //add product to outlet
        $owners->each(function ($owner)
        {
            $outlets = $owner->outlets;
            $products = $owner->products;
            
            $outlets->each(function ($outlet) use ($products)
            {
                foreach ($products->chunk(3) as $product) {
                    
                    $productIds = $product->lists('id')->toArray();
                    
                    $outlet->products()->attach($productIds);
                    
                }
                
            });
            
        });
        
        
           
    }
}
