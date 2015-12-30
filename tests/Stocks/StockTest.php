<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Transformer\StockDetailTransformer;
use Sikasir\V1\Transformer\EntryTransformer;
use Sikasir\V1\Transformer\StockOutTransformer;

class StockTest extends TestCase
{
    
    use DatabaseTransactions, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_stock_from_specific_outlet()
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
    
    public function test_get_stockentry_from_specific_outlet()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlet = Outlet::all()->random();
        
        $owner = $this->owner();
        
        $stocks = $repo->getStockEntriesPaginated($outlet->id, $owner);
        
        $data = $this->createPaginated($stocks, new EntryTransformer);
        
        $token = $this->getTokenAsOwner();
        
        $this->get('v1/outlets/'. $this->encode($outlet->id) . '/stock-entries', $token);
       
        $this->assertResponseStatus(200);
        
        $result = $data->toArray();
       
        
        //pop the meta array
        array_pop($result);
        
        $this->seeJson($result);
        
    }
    
    public function test_get_stockout_from_specific_outlet()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlet = Outlet::all()->random();
        
        $owner = $this->owner();
        
        $stocks = $repo->getStockOutsPaginated($outlet->id, $owner);
        
        $data = $this->createPaginated($stocks, new StockOutTransformer);
        
        $token = $this->getTokenAsOwner();
        
        $this->get('v1/outlets/'. $this->encode($outlet->id) . '/stock-outs', $token);
       
        $this->assertResponseStatus(200);
        
        $result = $data->toArray();
       
        //pop the meta array
        array_pop($result);
        
        $this->seeJson($result);
        
    }
    
   
}
