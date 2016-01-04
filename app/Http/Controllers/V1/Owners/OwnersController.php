<?php

namespace Sikasir\Http\Controllers\V1\Owners;

use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\OwnerTransformer;
use Sikasir\V1\User\OwnerRepository;
use Sikasir\Http\Requests\OwnerRequest;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;

class OwnersController extends ApiController
{

    public function __construct(ApiRespond $respond, OwnerRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $this->authorizing('read-owner');

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $paginator = $this->repo()->getPaginated($with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($paginator, new OwnerTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-specific-owner');
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $decodedId = $this->decode($id);

        $user = $this->repo()->find($decodedId);

        return $this->response()
                ->resource()
                ->including($include)
                ->withItem($user, new OwnerTransformer);
    }

    public function store(OwnerRequest $request)
    {
        $this->authorizing('create-owner');

        $this->repo()->save($request->all());
        
        return $this->response()->created();
    }

    public function update($id, OwnerRequest $request)
    {
        $this->authorizing('update-owner');
        
        $decodedId = $this->decode($id);

        $this->repo()->update($request->all(), $decodedId);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-owner');
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroy($decodedId);

        return $this->response()->deleted();
   }

}
