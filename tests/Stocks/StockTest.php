<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Transformer\StockDetailTransformer;

class StockTest extends TestCase
{
    
    use DatabaseTransactions, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_outlets()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlet = Outlet::all()->random();
        
        $owner = $this->owner();
        
        $stocks = $repo->getStocksPaginated($outlet->id, $owner);
        
        $data = $this->createPaginated($stocks, new StockDetailTransformer);
        
        $token = $this->getTokenAsOwner();
        
        $this->get('v1/outlets/'. $this->encode($outlet->id) . '/stocks', $token);
       
        $this->assertResponseStatus(200);
        
        $result = $data->toArray();
       
        array_pop($result);
        
        $this->seeJson($result);
        
    }
    
   
}
