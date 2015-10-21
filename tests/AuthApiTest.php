<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthApiTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_app_login()
    {
        
        $app = [
            'username' => 'owner',
            'password' => 'owner',
        ];
        
        $this->json('POST', '/v1/auth/app/login', $app);
        
        $this->assertResponseOk();
        
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_app_fail_login()
    {
        
        $app = [
            'username' => 'nonexist',
            'password' => 'noneexist',
        ];
        
        $this->json('POST', '/v1/auth/app/login', $app);
        
        $this->assertResponseStatus(404);
        
    }
}
