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
        
        $this->get('v1/outlets', $token);
       
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
        
        $this->get('v1/outlets/' . $id, $token);
        
        $this->seeJson($data->toArray());
        
    }
    
    public function test_create_an_outlet()
    {
        $outlet = factory(Outlet::class)->make();
        
        $token = $this->login();
        
        $this->json('POST', 'v1/outlets', $outlet->toArray(), $token);
        
        $this->assertResponseStatus(201);
        
    }
    
    public function test_update_an_outlet()
    {
        $outlet = factory(Outlet::class)->create();
        
        $newoutlet = factory(Outlet::class)->make()->toArray();
        
        $token = $this->login();
        
        $this->json('PUT', 'v1/outlets/'. $this->encode($outlet->id), $newoutlet, $token);
        
        $this->assertResponseStatus(204);
        
        $this->seeInDatabase('outlets', $newoutlet);
    }
    
    public function test_delete_an_outlet()
    {
        $outlet = factory(Outlet::class)->create();
        
        $token = $this->login();
        
        
        $this->delete('v1/outlets/'. $this->encode($outlet->id), [], $token);
        
        $this->assertResponseStatus(204);
        
        $this->dontSeeInDatabase('outlets', $outlet->toArray());
    }
}
