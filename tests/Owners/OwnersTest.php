<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\OwnerTransformer;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\OwnerRepository;
use Sikasir\V1\Traits\IdObfuscater;

class OwnersTest extends TestCase
{
    
    use DatabaseTransactions, IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_owners_paginated()
    {
        
        $repo = app(OwnerRepository::class);
        
        $data = $repo->getPaginated();
        
        $expected = $this->createPaginated($data, new OwnerTransformer);
        
        $token = $this->login();
        
        $link = 'v1/owners';
        
        $this->get($link, $token);
        
        $this->seeJson($expected->toArray());
        
        
    }
    
     /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_one_owner()
    {
        $user = factory(Owner::class)->create();
        
        $expected = $this->createItem($user, new OwnerTransformer);
        
        $link = 'v1/owners/' . $this->encode($user->id);
        
        $token = $this->login();
        
        $this->get($link, $token);
        
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_create_an_owner()
    {
        $owner = factory(Owner::class)->make();
        
        $token = $this->login();
        
        $this->post('/v1/owners', $owner->toArray(), $token);
        
        $this->assertResponseStatus(201);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_update_an_owner()
    {
        $owner = factory(Owner::class)->create();
        
        $updateowner = factory(Owner::class)->make();
        
        $id = $this->encode($owner->id);
        
        $token = $this->login();
        
        $this->put('/v1/owners/' . $id, $updateowner->toArray(), $token);
        
        $this->assertResponseStatus(204);
        
        $this->SeeInDatabase('owners', $updateowner->toArray());
        
    }
    
    public function test_delete_an_owner()
    {
        $owner = factory(Owner::class)->create();
        
        $id = $this->encode($owner->id);
        
        $token = $this->login();
        
        $this->delete('/v1/owners/' . $id, $token);
        
        $this->assertResponseStatus(204);
        
        $this->dontSeeInDatabase('owners', $owner->toArray());
    }
    
  
}
