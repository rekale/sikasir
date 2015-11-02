<?php

namespace Sikasir\Http\Controllers\User;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\Controller;
use \Sikasir\Transformer\OwnerTransformer;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    protected $req;
    protected $fractal;
    
    public function __construct(Request $request, \League\Fractal\Manager $fractal) {
        $this->req = $request;
        $this->setFractal($fractal);
    }
    
    public function mobileLogin()
    {
        $username = $this->req->input('username');
        $password = $this->req->input('password');
        
        
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
            'email' => $this->req->input('email'),
            'password' => $this->req->input('password'),
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
    
    public function signup(JWTAuth $auth)
    {
        $data = $this->req->only('email', 'password', 'name');
        
        try {
            $user = \Sikasir\User::create([
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
    
    public function testEncode($id)
    {
        return $this->encode($id);
    }
    
    public function testDecode($id)
    {
        return $this->decode($id);
    }
    
}
