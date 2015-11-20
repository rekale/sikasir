<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class EmployeeTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_employees_paginated()
    {
        $this->visit('v1/employees');
        
        
        
        $this->seeJson();
        
        
    }
    
  
}
