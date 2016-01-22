<?php

namespace Sikasir\Http\Controllers\V1\Tenants;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\User\OwnerRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Transformer\OwnerTransformer;

class TenantController extends ApiController
{
    
    public function __construct(ApiRespond $respond, OwnerRepository $repo, JWTAuth $auth) 
    {

        parent::__construct($respond, $auth, $repo);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $ownerId = $this->currentUser()->getOwnerId();
        
        $item = $this->repo()->findWith($ownerId, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withItem($item, new OwnerTransformer);
    }

    
}
