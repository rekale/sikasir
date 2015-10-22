<?php

namespace Sikasir\Http\Controllers\User;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use \Sikasir\Transformer\OwnerTransformer;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{
    
    public function mobileLogin()
    {
        $username = $this->request()->input('username');
        $password = $this->request()->input('password');
        
        
        $app = \Sikasir\User\App::whereUsername($username)->get();
        
        if ($app->isEmpty()) {
            return $this->respondNotFound('user not found');
        }
        
        if(! \Hash::check($password, $app[0]->password)) {
            return $this->respondNotFound('password is not match');
        }
        
        $include = ['outlets.employees'];
        $this->fractal()->parseIncludes($include);
        
        $owner = $app[0]->owner()->with($include)->get();
        
        return $this->respondWithCollection($owner, new OwnerTransformer);
        
    }
    
    public function login(JWTAuth $auth)
    {
        
        $credentials = [
            'email' => $this->request()->input('email'),
            'password' => $this->request()->input('password'),
        ];
        
        if ( ! $token = $auth->attempt($credentials)) {
            return $this->respondNotFound('email or password don\'t match our record');
        }
        
        return $this->respond([
            'success' => [
                'token' => $token,
                'code' => 200
            ]
        ]);
        
    }
    
}
