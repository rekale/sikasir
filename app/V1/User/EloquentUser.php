<?php

namespace Sikasir\V1\User;


use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Interfaces\CurrentUser;


class EloquentUser implements CurrentUser
{
    private $auth;
    private $currentUser;
    
    public function __construct(JWTAuth $auth) 
    {
        $this->auth = $auth;
        
        $this->currentUser = $auth->toUser();
    }
    
     /**
     *
     * check if current user have rights to do current job
     * 
     * @param string $doThis
     *
     * @return void|\Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function authorizing($doThis)
    {
        if($this->currentUser->cant($doThis)) {
            abort(403);
        }
    }
    
    /**
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->currentUser->id;
    }

}
