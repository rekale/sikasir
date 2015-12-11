<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Variant;

class ProductTest extends TestCase
{
    
    use DatabaseTransactions, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * get outlet's product
     *
     * @return void
     */
    public function test_get_all_product_Paginated()
    {
        $repo = app(ProductRepository::class);
        
        $data = $repo->getPaginatedForOwner($this->owner());
        
        $expected = $this->createPaginated($data, new ProductTransformer);
        
        $token = $this->getTokenAsOwner();
        
        $link = 'v1/products';
       
        $this->get($link, $token);
        
        $this->assertResponseOk();
        
        $this->seeJson($expected->toArray());
        
    }
    
    public function test_get_one_product()
    {   
        $category = factory(Category::class)->create([
            'owner_id' => $this->owner()->id,
        ]);
        
        $product = factory(Product::class)->create([
            'category_id' => $category->id,
        ]);
        
        $expected = $this->createItem($product, new ProductTransformer);
        
        $link = 'v1/products/' . $this->encode($product->id);
        
        $token = $this->getTokenAsOwner();
        
        $this->get($link, $token);
        
        $this->assertResponseStatus(200);
    }
    
     public function test_create_an_product()
    {
        
        $category = factory(Category::class)->create([
            'owner_id' => $this->owner()->id,
        ]);
        
        $product = factory(Product::class)->make([
            'category_id' => $this->encode($category->id),
        ]);
        
        $variants = factory(Variant::class, 3)->make();
        
        $data = $product->toArray();
        
        $data['variants'] = $variants->toArray();
        
        $token = $this->getTokenAsOwner();
        
        $this->post('/v1/products', $data, $token);
        
        $this->assertResponseStatus(201);
        
        $this->seeInDatabase('products', [
            'category_id' => $category->id,
            'name' => $product->name,
            'barcode' => $product->barcode,
            'unit' => $product->unit,
        ]);
        
        foreach ($data['variants'] as $variant) {
            $this->seeInDatabase('variants', $variant);
        }
    }
    
    public function test_delete_an_cashier()
    {
        $category = factory(Category::class)->create([
            'owner_id' => $this->owner()->id,
        ]);

        $product = factory(Product::class)->create([
            'category_id' => $category->id,
        ]);
        
        $id = $this->encode($product->id);
        
        $token = $this->getTokenAsOwner();
        
        $this->delete('/v1/products/' . $id, [], $token);
        
        
        $this->assertResponseStatus(200);
        
        $this->dontSeeInDatabase('products', $product->toArray());
        
    }
        
}
