<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\ProductTransformer;

class ProductTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * get outlet's product
     *
     * @return void
     */
    public function test_get_product_from_specific_outlet()
    {
        $repo = app(OutletRepository::class);
        
        $id = $repo->getSome(5)->random()->id;
        
        $outletId = $this->encode($id);
        
        $products = $repo->getProducts($id);
        
        $data = $this->createPaginated($products, new ProductTransformer);
        
        $this->visit('v1/outlets/' . $outletId . '/products');
        
        $this->seeJson($data->toArray());
        
        
    }
        
}
