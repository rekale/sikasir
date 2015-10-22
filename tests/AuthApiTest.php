<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthApiTest extends TestCase
{
    
    use DatabaseTransactions;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_mobile_login()
    {
        
        $app = [
            'username' => 'owner',
            'password' => 'owner',
        ];
        
        $this->json('POST', '/v1/auth/mobile/login', $app);
        
        $this->assertResponseOk();
        
    }
    
    /**
     * test fail login for mobile
     *
     * @return void
     */
    public function test_mobile_fail_login()
    {
        
        $app = [
            'username' => 'nonexist',
            'password' => 'noneexist',
        ];
        
        $this->json('POST', '/v1/auth/mobile/login', $app);
        
        $this->assertResponseStatus(404);
        
    }
    
    public function test_login()
    {
        
        $input = [
            'email' => 'pat67@ullrich.com',
            'password' => 'owner',
        ];
          
        $this->json('POST', '/v1/auth/login', $input);
        
        $this->assertResponseStatus(200);
    }
}
