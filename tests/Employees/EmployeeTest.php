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
        
        $owner = $this->owner();
        
        $data = $repo->getPaginatedForOwner($owner);
        
        $expected = $this->createPaginated($data, new EmployeeTransformer);
        
        $token = $this->getTokenAsOwner();
        
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
        $employee = $this->owner()->employees[0];
        
        $expected = $this->createItem($employee, new EmployeeTransformer);
        
        $link = 'v1/employees/' . $this->encode($employee->id);
        
        $token = $this->getTokenAsOwner();
        
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
        
        $token = $this->getTokenAsOwner();
        
        $data['email'] = 'test@aja.com';
        
        $data['password'] = '12345';
        
        $outlets = $this->owner()->outlets;
        
        foreach ($outlets as $outlet) {
            $data['outlet_id'][] = $this->encode($outlet->id);
        }
        
        $this->post('/v1/employees', $data, $token);
        
        $this->assertResponseStatus(201);
        
        $this->seeInDatabase('employees', [
            'name' => $employee->name,
            'phone' => $employee->phone, 
        ]);
        
        
        $this->seeInDatabase('users', [
            'email' => 'test@aja.com',
        ]);
       
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_update_an_employee()
    {   
        //get the current resorce
        $employee = $this->owner()->employees[0];
        //make the input update
        $updateemployee = factory(Employee::class)->make();
        
        $data = $updateemployee->toArray();
        
        // outlet
        $data['outlet_id'][] = $this->encode($employee->outlets[0]->id);
        
        $id = $this->encode($employee->id);
        
        $token = $this->getTokenAsOwner();
        
        $this->put('/v1/employees/' . $id, $data, $token);
        
        $this->assertResponseStatus(200);
        
        $this->seeInDatabase('employees', [
            'id' => $employee->id,
            'name' => $updateemployee->name,
        ]);
        
        $this->seeInDatabase('employee_outlet', [
            'employee_id' => $employee->id,
            'outlet_id' => $employee->outlets[0]->id,
        ]);
        
    }
    
    public function test_delete_an_employee()
    {
        $employee = $this->owner()->employees[0];
        
        $id = $this->encode($employee->id);
        
        $token = $this->getTokenAsOwner();
        
        $this->delete('/v1/employees/' . $id, [], $token);
        
        
        $this->assertResponseStatus(200);
        
    }
    
  
    
  
}
