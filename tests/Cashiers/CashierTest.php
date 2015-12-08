<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\CashierTransformer;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\Repositories\CashierRepository;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Outlets\Outlet;

class CashierTest extends TestCase
{
    
    use DatabaseTransactions, IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_cashiers_paginated()
    {
        
        $repo = app(CashierRepository::class);
        
        $data = $repo->getPaginatedForOwner($this->owner());
        
        $expected = $this->createPaginated($data, new CashierTransformer);
        
        $token = $this->loginAsOwner();
        
        $link = 'v1/cashiers';
        
        $this->get($link, $token);
        
        $this->seeJson($expected->toArray());
        
        
    }
    
     /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_one_cashier()
    {   
     
        $cashier = $this->owner()->cashiers[0];
        
        $expected = $this->createItem($cashier, new CashierTransformer);
        
        $link = 'v1/cashiers/' . $this->encode($cashier->id);
        
        $token = $this->loginAsOwner();
        
        $this->get($link, $token);
        
        $this->assertResponseStatus(200);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_create_an_cashier()
    {
        $cashier = factory(Cashier::class)->make();
        
        $data = $cashier->toArray();
        
        $token = $this->loginAsOwner();
        
        $data['email'] = 'test@aja.com';
        
        $data['password'] = bcrypt('12345');
        
        $data['outlet_id'] = $this->encode(Outlet::findOrFail(1)->id);
        
        $this->post('/v1/cashiers', $data, $token);
        
        $this->assertResponseStatus(201);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_update_an_cashier()
    {
        $cashier = factory(Cashier::class)->create();
        
        $updatecashier = factory(Cashier::class)->make();
        
        $id = $this->encode($cashier->id);
        
        $token = $this->loginAsOwner();
        
        $data = $updatecashier->toArray();
        
        $data['outlet_id'] = $this->encode(Outlet::findOrFail(1)->id);
        
        $this->put('/v1/cashiers/' . $id, $data, $token);
        
        $this->assertResponseStatus(200);
        
    }
    
    public function test_delete_an_cashier()
    {
        $cashier = factory(Cashier::class)->create();
        
        $id = $this->encode($cashier->id);
        
        $token = $this->loginAsOwner();
        
        $this->delete('/v1/cashiers/' . $id, [], $token);
        
        
        $this->assertResponseStatus(200);
        
    }
    
  
}
