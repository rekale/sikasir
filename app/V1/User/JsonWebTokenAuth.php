<?php

namespace Sikasir\V1\User;


use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Interfaces\AuthInterface;


class JsonWebTokenAuth implements AuthInterface
{
    private $auth;
    private $currentUser;
    
    public function __construct(JWTAuth $auth) 
    {
        $this->auth = $auth;
        
        $this->currentUser = $auth->toUser();
    }
    
    
    /**
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->currentUser->id;
    }
    
    public function currentUser()
    {
    	return $this->currentUser;
    }

}
