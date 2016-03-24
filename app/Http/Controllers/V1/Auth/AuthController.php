<?php

namespace Sikasir\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\User\Company;
use Sikasir\V1\Traits\ApiRespond;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    protected $response;


    public function __construct(ApiRespond $response) 
    {
        $this->response = $response;
        
    }
    
    public function login(JWTAuth $auth, Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
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
                    'user_id' => $this->encode($loggedUser->id),
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
        $data = $this->request()->only('email', 'password', 'name');
        
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
    
    public function refresh(JWTAuth $auth)
    {
        $token = $auth->parseToken()->refresh();
        
        return $this->response->success($token);
    }
    
    public function getCompanyActiveState($companyId)
    {
        return Company::findOrFail($companyId)->active;
    }

}
