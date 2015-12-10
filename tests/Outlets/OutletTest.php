<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\V1\Outlets\BusinessField;

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
        
        $outlets = $repo->getPaginatedForOwner($this->owner());
        
        $token = $this->loginAsOwner();
        
        $data = $this->createPaginated($outlets, new OutletTransformer);
        
        $this->get('v1/outlets', $token);
       
        $this->assertResponseStatus(200);
        
        $this->seeJson($data->toArray());
        
    }
    
    public function test_get_an_outlet()
    {
        
        $outlet = factory(Outlet::class)->create([
           'owner_id' => $this->owner()->id, 
        ]);
        
        $id = $this->encode($outlet->id);
        
        $data = $this->createItem($outlet, new OutletTransformer());
        
        $token = $this->loginAsOwner();
        
        $this->get('v1/outlets/' . $id, $token);
        
        $this->assertResponseStatus(200);
        
        $this->seeJson($data->toArray());
        
    }
    
    public function test_create_an_outlet()
    {
        $outlet = factory(Outlet::class)->make([
            'owner_id' => null,
            'business_field_id' => $this->encode(
                factory(BusinessField::class)->create()->id
            ),
        ]);
        
        $token = $this->loginAsOwner();
        
        $this->json('POST', 'v1/outlets', $outlet->toArray(), $token);
        
        $this->assertResponseStatus(201);
       
        $this->seeInDatabase('outlets', [
            'business_field_id' => $this->decode($outlet->business_field_id),
            'name' => $outlet->name,
            'code' => $outlet->code,
            'address' => $outlet->address,
        ]);
        
    }
    
    public function test_update_an_outlet()
    {
        $outlet = factory(Outlet::class)->create([
            'owner_id' => $this->owner()->id,
        ]);
        
        $newoutlet = factory(Outlet::class)->make([
            'business_field_id' => $this->encode(
                factory(BusinessField::class)->create()->id
            ),
        ]);
        
        $token = $this->loginAsOwner();
        
        $this->json('PUT', 'v1/outlets/'. $this->encode($outlet->id), $newoutlet->toArray(), $token);
        
        $this->assertResponseStatus(200);
        
        $this->seeInDatabase('outlets', [
            'id' => $outlet->id,
            'business_field_id' => $this->decode($newoutlet->business_field_id),
            'name' => $newoutlet->name,
            'code' => $newoutlet->code,
            'address' => $newoutlet->address,
        ]);
    }
    
    public function delete_an_outlet()
    {
        $outlet = $this->owner()->outlets[0];
        
        $id = $this->encode($outlet->id);
        
        $token = $this->loginAsOwner();
        
        $this->delete('/v1/outlets/' . $id, $token);
        
        $this->assertResponseOk();
        
        $this->dontSeeInDatabase('outlets', $outlet->toArray());
    }
   
}
