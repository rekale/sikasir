<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_get_all_customer()
    {
        $this->visit('v1/customer');
        
        $this->seeJson();
        
        
    }
    
  
}
