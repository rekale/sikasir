<?php

namespace Sikasir\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\Controller;
use \Sikasir\V1\Transformer\OwnerTransformer;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $request;
    protected $response;
    
    public function __construct(\Sikasir\V1\Traits\ApiRespond $respond, Request $request) {
        $this->response = $respond;
        
        $this->request = $request;
    }
    
    public function mobileLogin()
    {
        $username = $this->request->input('username');
        $password = $this->request->input('password');
        
        
        $app = \Sikasir\V1\User\App::whereUsername($username)->get();
        
        if ($app->isEmpty()) {
            return $this->response->notFound('user not found');
        }
        
        if(! \Hash::check($password, $app[0]->password)) {
            return $this->response->notFound('password is not match');
        }
        
        $include = ['outlets.employees'];
        
        $owner = $app[0]->owner()->with($include)->get();
        
        return $this->response->resource()
                ->including($include)
                ->withCollection($owner, new OwnerTransformer);
        
    }
    
    public function login(JWTAuth $auth)
    {
        
        $credentials = [
            'email' => $this->request->input('email'),
            'password' => $this->request->input('password'),
        ];
        
        if ( ! $token = $auth->attempt($credentials)) {
            return $this->response->notFound('email or password don\'t match our record');
        }
        
        return $this->response->respond([
            'success' => [
                'token' => $token,
                'code' => 200
            ]
        ]);
        
    }
    
    public function signup(JWTAuth $auth)
    {
        $data = $this->request->only('email', 'password', 'name');
        
        try {
            $user = \Sikasir\V1\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
        } catch (Exception $e) {
            
            return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
        }

        $token = $auth->fromUser($user);

        return response()->json(compact('token'));
    }

}
