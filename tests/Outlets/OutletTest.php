<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Transformer\OutletTransformer;

class OutletTest extends TestCase
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
        
        $outlets = $repo->getPaginated();
        
        $token = $this->login();
        
        $data = $this->createPaginated($outlets, new OutletTransformer());
        
        $this->visit('v1/outlets?token='.$token);
       
        $this->seeJson();
        
    }
    
    public function test_get_an_outlet()
    {
        
        $repo = new OutletRepository(new Outlet);
        
        $outlet = $repo->getSome(5)->random();
        
        $id = $this->encode($outlet->id);
        
        $item = $repo->find($id);
        
        $data = $this->createItem($item, new OutletTransformer());
        
        $token = $this->login();
        
        $this->visit('v1/outlets/' . $id . '?token='.$token);
        
        $this->seeJson($data->toArray());
        
    }
    
    public function test_create_an_outlet()
    {
        $outlet = factory(Outlet::class)->make()->toArray();
        
        $token = $this->login();
        
        $this->json('POST', 'v1/outlets?token=' . $token, $outlet);
        
        $this->assertResponseStatus(201);
        
        $this->seeInDatabase('outlets', $outlet);
    }
}
