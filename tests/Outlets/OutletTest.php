<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\Outlets\OutletRepository;
use Sikasir\Outlets\Outlet;
use Sikasir\Transformer\OutletTransformer;

class OutletTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware, Sikasir\Traits\IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_outlets()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlets = $repo->getPaginated();
        
        $data = $this->createPaginated($outlets, new OutletTransformer());
        
        $this->visit('v1/outlets');
       
        $this->seeJson();
        
    }
    
    public function test_get_an_outlet()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlet = $repo->getSome(5)->random();
        
        $id = $this->encode($outlet->id);
        
        $item = $repo->find($id);
        
        $data = $this->createItem($item, new OutletTransformer());
        
        $this->visit('v1/outlets/' . $id);
        
        $this->seeJson($data->toArray());
        
    }
}
