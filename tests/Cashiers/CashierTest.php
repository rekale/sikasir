<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\CashierTransformer;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\Repositories\CashierRepository;
use Sikasir\V1\Traits\IdObfuscater;

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
        
        $data = $repo->getPaginated();
        
        $expected = $this->createPaginated($data, new CashierTransformer);
        
        $token = $this->login();
        
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
        $user = factory(Cashier::class)->create();
        
        $expected = $this->createItem($user, new CashierTransformer);
        
        $link = 'v1/cashiers/' . $this->encode($user->id);
        
        $token = $this->login();
        
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
        
        $token = $this->login();
        
        $this->post('/v1/cashiers', $cashier->toArray(), $token);
        
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
        
        $token = $this->login();
        
        $this->put('/v1/cashiers/' . $id, $updatecashier->toArray(), $token);
        
        $this->assertResponseStatus(204);
        
        $this->SeeInDatabase('cashiers', $updatecashier->toArray());
        
    }
    
    public function test_delete_an_cashier()
    {
        $cashier = factory(Cashier::class)->create();
        
        $id = $this->encode($cashier->id);
        
        $token = $this->login();
        
        $this->delete('/v1/cashiers/' . $id, $token);
        
        $this->assertResponseStatus(204);
        
        $this->dontSeeInDatabase('cashiers', $cashier->toArray());
    }
    
  
}