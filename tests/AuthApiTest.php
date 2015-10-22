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
        $fake = Faker\Factory::create();
        
        $employeeName = $fake->name;
        
        $employee = Sikasir\User\Employee::create([
            'name' => $employeeName,
            'phone' => $fake->phoneNumber,
            'address' => $fake->address,
            'icon' => $fake->imageUrl(300, 200, 'people'),
            'void_access' => $fake->boolean(),
        ]);

        $employee->user()->save(new Sikasir\User\User([
            'name' => $employeeName,
            'email' => $fake->email,
            'password' => bcrypt('12345'),
        ]));
        
        $input = [
            'email' => $employee->user->email,
            'password' => '12345',
        ];
          
        $this->json('POST', '/v1/auth/login', $input);
        
        $this->assertResponseStatus(200);
    }
}
