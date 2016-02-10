<?php

namespace Sikasir\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Transformer\CompanyTransformer;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\User\Company;

class AuthController extends Controller
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
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
        
        
        $company = Company::with('outlets.users')->whereUsername($username)->first();
        
        if (is_null($company)) {
            return $this->response->notFound('user not found');
        }
        
        if(! \Hash::check($password, $company->password)) {
            return $this->response->notFound('password is not match');
        }
        
        
        return $this->response
                ->resource()
                ->including('outlets.users')
                ->withItem($company, new CompanyTransformer);
        
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
        
        $loggedUser = $auth->toUser($token)->load(['outlets']);
        
        $loggedUserAbilities = $loggedUser->getAbilities()->lists('name');
        
        return $this->response->respond([
            'success' => [
                'token' => $token,
                'user' => $loggedUser->toArray(),
                'expire_at' => config('jwt.ttl'),
                'privileges' => $loggedUserAbilities,
                'code' => 200,
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
