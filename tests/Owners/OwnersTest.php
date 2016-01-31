<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\OwnerTransformer;
use Sikasir\V1\User\Company;
use Sikasir\V1\User\OwnerRepository;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\User\User;

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
        
        $token = $this->loginAsAdmin();
        
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
        
        $owner = $this->createOwner();
        
        $expected = $this->createItem($owner, new OwnerTransformer);
        
        $link = 'v1/owners/' . $this->encode($owner->id);
        
        $token = $this->loginAsAdmin();
        
        $this->get($link, $token);
        
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_create_an_owner()
    {
      
        $owner = factory(Company::class)->make();
        $user = factory(User::class)->make();
        
        $data = $owner->toArray();
        
        $data['email'] = $user->email;
        $data['password'] = '12345';
        
        $token = $this->loginAsAdmin();
        
        $this->post('/v1/owners', $data, $token);
        
        $this->assertResponseStatus(201);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_update_an_owner()
    {
        
        $owner = $this->createOwner();
        
        $updateowner = factory(Company::class)->make();
        
        $id = $this->encode($owner->id);
        
        $token = $this->loginAsAdmin();
        
        $this->put('/v1/owners/' . $id, $updateowner->toArray(), $token);
        
        $this->assertResponseStatus(200);
        
        $this->SeeInDatabase('owners', [
            'id' => $owner->id,
            'name' => $updateowner->name,
        ]);
        
    }
    
    public function test_delete_an_owner()
    {
        
        $owner = $this->createOwner();
        
        $id = $this->encode($owner->id);
        
        $token = $this->loginAsAdmin();
        
        $this->delete('/v1/owners/' . $id, [], $token);
        
        $this->assertResponseStatus(200);
        
        $this->dontSeeInDatabase('owners', $owner->toArray());
    }
    
  
}
