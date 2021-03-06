<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Company;
use Sikasir\V1\Products\Variant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create product category
        $company = Company::findOrFail(1);
        
       
            $categories = $company->categories()->saveMany(
                factory(Category::class, 3)->make()
            );
            
            $outlets = $company->outlets;
            
            foreach (range(0, 2) as $i) {
                
                $products = factory(Product::class, 20)->create([
                	'company_id' => $company->id,
                    'category_id' => $categories[$i]->id,
                    'outlet_id' => $outlets[$i]->id,
                ]);
                
                //make variant /subproduct
                foreach ($products as $product) {
                    $product->variants()->saveMany(
                        factory(Variant::class, 50)->make()
                    );
                }
            }
            
            
       
        
    }
}
