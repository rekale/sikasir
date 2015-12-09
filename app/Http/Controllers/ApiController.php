<?php

namespace Sikasir\Http\Controllers;

use Sikasir\Http\Controllers\Controller;
use Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\User\User;

class ApiController extends Controller
{

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
     * @return Sikasir\V1\Traits\ApiRespond
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * return current logged user
     *
     * return Tymon\JWTAuth\JWTAuth
     */
    public function auth()
    {
       return $this->auth;
    }
    
    public function currentUser()
    {
        return $this->auth->toUser();
    }

    /**
     * return repository
     *
     * @return Sikasir\V1\Repositories\RepositoryInterface
     */
    public function repo()
    {
        return $this->repo;
    }

    /**
     *
     * @param type $doThis
     *
     */
    public function authorizing($doThis)
    {
        if($this->auth()->toUser()->cant($doThis)) {
            abort(403);
        }
    }

}
