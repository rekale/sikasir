<?php

namespace Sikasir\Http\Controllers\V1\Cashiers;


use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\CashierRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\CashierTransformer;
use Sikasir\Http\Requests\CashierRequest;

class CashiersController extends ApiController
{

    public function __construct(ApiRespond $respond, JWTAuth $auth, CashierRepository $repo) 
    {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $this->authorizing('read-cashier');

        $paginator = $this->repo()->getPaginated();

        return $this->response()->withPaginated($paginator, new CashierTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-cashier');

        $user = $this->repo()->find($id);

        return $this->response()->withItem($user, new CashierTransformer);
    }

    public function store(CashierRequest $request)
    {
        $this->authorizing('create-cashier');

        $owner = $this->getTheOwner($this->auth()->toUser());

        $this->repo()->saveForOwner($request->all(), $owner);
        

        return $this->response()->created();
    }

    public function update($id, CashierRequest $request)
    {
        $this->authorizing('update-cashier');

        $this->repo()->update($request->all(), $id);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-cashier');

        $this->repo()->destroy($id);

        return $this->response()->deleted();
   }
}
