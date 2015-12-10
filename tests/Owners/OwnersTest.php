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
        $user = factory(Owner::class)->create();
        
        $expected = $this->createItem($user, new OwnerTransformer);
        
        $link = 'v1/owners/' . $this->encode($user->id);
        
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
        $user = factory(Sikasir\V1\User\User::class)->make([
            'password' => bcrypt('12345'),
        ]);
        
        $owner = factory(Owner::class)->make([
            'user_id' => null,
        ]);
        
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
        $owner = factory(Owner::class)->create();
        
        $updateowner = factory(Owner::class)->make([
            'user_id' => null,
        ]);
        
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
        $owner = factory(Owner::class)->create();
        
        $id = $this->encode($owner->id);
        
        $token = $this->loginAsAdmin();
        
        $this->delete('/v1/owners/' . $id, [], $token);
        
        $this->assertResponseStatus(200);
        
        $this->dontSeeInDatabase('owners', $owner->toArray());
    }
    
  
}
