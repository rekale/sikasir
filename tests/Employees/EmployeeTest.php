<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\EmployeeTransformer;
use Sikasir\V1\Repositories\EmployeeRepository;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\User\Employee;

class EmployeeTest extends TestCase
{
    
     use DatabaseTransactions, IdObfuscater;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_employees_paginated()
    {
        
        $repo = app(EmployeeRepository::class);
        
        $data = $repo->getPaginated();
        
        $expected = $this->createPaginated($data, new EmployeeTransformer);
        
        $token = $this->loginAsOwner();
        
        $link = 'v1/employees';
        
        $this->get($link, $token);
        
        $this->seeJson($expected->toArray());
        
        
    }
    
     /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_one_employee()
    {
        $user = factory(Employee::class)->create();
        
        $expected = $this->createItem($user, new EmployeeTransformer);
        
        $link = 'v1/employees/' . $this->encode($user->id);
        
        $token = $this->loginAsOwner();
        
        $this->get($link, $token);
        
        $this->assertResponseStatus(200);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_create_an_employee()
    {
        $employee = factory(Employee::class)->make();
        
        $data = $employee->toArray();
        
        $token = $this->loginAsOwner();
        
        $data['email'] = 'test@aja.com';
        
        $data['password'] = bcrypt('12345');
        
        $this->post('/v1/employees', $data, $token);
        
        $this->assertResponseStatus(201);
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_update_an_employee()
    {
        $employee = factory(Employee::class)->create();
        
        $updateemployee = factory(Employee::class)->make();
        
        $id = $this->encode($employee->id);
        
        $token = $this->loginAsOwner();
        
        $this->put('/v1/employees/' . $id, $updateemployee->toArray(), $token);
        
        $this->assertResponseStatus(200);
        
    }
    
    public function test_delete_an_employee()
    {
        $employee = factory(Employee::class)->create();
        
        $id = $this->encode($employee->id);
        
        $token = $this->loginAsOwner();
        
        $this->delete('/v1/employees/' . $id, [], $token);
        
        
        $this->assertResponseStatus(200);
        
    }
    
  
    
  
}
