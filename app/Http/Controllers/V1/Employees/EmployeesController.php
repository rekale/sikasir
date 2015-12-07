<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Illuminate\Http\Request;
use \Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\EmployeeTransformer;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Repositories\EmployeeRepository;
use Sikasir\Http\Requests\EmployeeRequest;

class EmployeesController extends ApiController
{

    public function __construct(ApiRespond $respond, JWTAuth $auth, EmployeeRepository $repo)
    {
        parent::__construct($respond, $auth, $repo);
    }

    public function index()
    {
        $this->authorizing('read-staff');

        $paginator = $this->repo()->getPaginated();

        return $this->response()->withPaginated($paginator, new EmployeeTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-staff');

        $user = $this->repo()->find($id);

        return $this->response()->withItem($user, new EmployeeTransformer);
    }

    public function store(EmployeeRequest $request)
    {
        $this->authorizing('create-staff');

        $owner = $this->getTheOwner($this->auth()->toUser());

        $this->repo()->saveForOwner($request->all(), $owner);
        

        return $this->response()->created();
    }

    public function update($id, EmployeeRequest $request)
    {
        $this->authorizing('update-staff');

        $this->repo()->update($request->all(), $id);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-staff');

        $this->repo()->destroy($id);

        return $this->response()->deleted();
   }
}
