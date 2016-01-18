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

        $paginator = $this->repo()->getPaginatedForOwner(
            $this->currentUser()->toOwner()
        );

        return $this->response()
                ->resource()
                ->withPaginated($paginator, new EmployeeTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-staff');
        
        $decodedId = $this->decode($id);
        
        $user = $this->repo()->findFOrOwner($decodedId, $this->currentUser()->toOwner());

        return $this->response()
                ->resource()
                ->withItem($user, new EmployeeTransformer);
    }

    public function store(EmployeeRequest $request)
    {
        //$this->authorizing('create-staff');

        $owner = $this->auth()->toUser()->toOwner();
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->saveForOwner($dataInput, $owner);
        

        return $this->response()->created();
    }

    public function update($id, EmployeeRequest $request)
    {
        $this->authorizing('update-staff');
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);

        $this->repo()->updateForOwner($decodedId, $dataInput, $this->currentUser()->toOwner());

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-staff');
        
        $decodedId = $this->decode($id);

        $this->repo()->destroyForOwner($decodedId, $this->currentUser()->toOwner());

        return $this->response()->deleted();
   }
}
