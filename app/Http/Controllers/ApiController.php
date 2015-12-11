<?php

namespace Sikasir\Http\Controllers;

use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\Repository;

class ApiController extends Controller
{
    
    use IdObfuscater;
    
    /**
     *
     * @var Sikasir\V1\Traits\ApiRespond
     */
    private $response;
    private $auth;
    private $repo;

    public function __construct(ApiRespond $respond, JWTAuth $auth, Repository $repo)
    {
        $this->response = $respond;
        $this->auth = $auth;
        $this->repo = $repo;
    }

    /**
     * return response
     *
     * @return \Sikasir\V1\Traits\ApiRespond
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * return current auth
     *
     * @return \Tymon\JWTAuth\JWTAuth
     */
    public function auth()
    {
       return $this->auth;
    }
    
    /**
     * return current logged user
     *
     * @return \Sikasir\V1\User\User
     */
    public function currentUser()
    {
        return $this->auth->toUser();
    }

    /**
     * return repository
     *
     * @return \Sikasir\V1\Repositories\RepositoryInterface
     */
    public function repo()
    {
        return $this->repo;
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
        if($this->currentUser()->cant($doThis)) {
            abort(403);
        }
    }

}
