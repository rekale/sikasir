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
        $this->authorizing('read.owner');

        $paginator = $this->repo()->getPaginated();

        return $this->response()->withPaginated($paginator, new OwnerTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read.owner');

        $user = $this->repo()->find($id);

        return $this->response()->withItem($user, new OwnerTransformer);
    }

    public function store(OwnerRequest $request)
    {
        $this->authorizing('create.owner');

        $this->repo()->save($request->all());
        
        $this->repo()->createUser([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return $this->response()->created();
    }

    public function update($id, OwnerRequest $request)
    {
        $this->authorizing('update.owner');

        $this->repo()->update($request->all(), $id);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete.owner');

        $this->repo()->destroy($id);

        return $this->response()->deleted();
   }

}
