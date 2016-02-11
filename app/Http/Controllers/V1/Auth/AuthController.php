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
    
    public function login(JWTAuth $auth)
    {
        
        $credentials = [
            'email' => $this->request->input('email'),
            'password' => $this->request->input('password'),
        ];
        
        $loggedIn = $auth->attempt($credentials);
        
        if ( ! $loggedIn ) {
            return $this->response->notFound('email or password don\'t match our record');
        }
        
        $loggedUser = $auth->toUser($loggedIn);
        
        $active = $this->getCompanyActiveState($loggedUser->getCompanyId());
        
        if($active) {
            $loggedUserAbilities = $loggedUser->getAbilities()->lists('name');
        
            return $this->response->respond([
                'success' => [
                    'token' => $loggedIn,
                    'user_id' => $loggedUser->id,
                    'expire_at' => config('jwt.ttl'),
                    'privileges' => $loggedUserAbilities,
                    'code' => 200,
                ]
            ]);
        }
        else{
            return $this->response->notFound('your company account is not active');
        }
        
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
    
    public function getCompanyActiveState($companyId)
    {
        return Company::findOrFail($companyId)->active;
    }

}
