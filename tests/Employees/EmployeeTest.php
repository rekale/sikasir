<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Transformer\EmployeeTransformer;

class EmployeeTest extends TestCase
{
    
    use DatabaseTransactions;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_employees_paginated()
    {
        
        $token = $this->loginAsOwner();
        
        $owner = $this->getOwner();
        
        $data = $owner->employees()->paginate();
        
        $expected = $this->createPaginated($data, new EmployeeTransformer);
        
        $link = 'v1/employees?token=' . $token;
        
        $this->visit($link);
        
        $this->seeJson($expected->toArray());
        
        
    }
    
  
}
