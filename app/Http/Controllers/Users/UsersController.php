<?php

namespace Sikasir\Http\Controllers\Users;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use \Sikasir\Transformer\OwnerTransformer;
use Sikasir\Transformer\EmployeeTransformer;
use Tymon\JWTAuth\JWTAuth;

class UsersController extends ApiController
{
    protected $request;
    
    public function __construct(\Sikasir\Traits\ApiRespond $respond, Request $request) {
        parent::__construct($respond);
        
        $this->request = $request;
    }
    
    public function profile(JWTAuth $auth)
    {
        $user = $auth->parseToken()->toUser();
        
        $transformer = $user->isOwner() ? new OwnerTransformer : new EmployeeTransformer;
        
        return $this->response->withItem($user->userable, $transformer);
    }
    

}
