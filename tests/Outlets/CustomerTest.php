<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\CustomerTransformer;

class CustomerTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_customer()
    {
        $repo = app(OutletRepository::class);
        
        $id = $repo->getSome(5)->random()->id;
        
        $encodedId = $this->encode($id);
        
        $customers = $repo->getCustomers($id);
        
        $data = $this->createPaginated($customers, new CustomerTransformer);
        
        $this->visit('v1/outlets/' . $encodedId . '/customers');
        
        $this->seeJson($data->toArray());
           
    }
    
  
}
