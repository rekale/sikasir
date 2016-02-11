<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Illuminate\Http\Request;
use \Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Repositories\UserRepository;
use Sikasir\Http\Requests\EmployeeRequest;

class EmployeesController extends ApiController
{

    public function __construct(ApiRespond $respond, JWTAuth $auth, UserRepository $repo)
    {
        parent::__construct($respond, $auth, $repo);
    }

    public function index()
    {
        $currentUser = $this->currentUser();
        
        $this->authorizing($currentUser, 'read-staff');
        
        $paginator = $this->repo()->getPaginatedForOwner(
            $currentUser->getCompanyId()
        );
        
        return $this->response()
                ->resource()
                ->withPaginated($paginator, new UserTransformer);
    }

    public function show($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-staff');
       
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $user = $this->repo()->findFOrOwner($decodedId, $owner);

        return $this->response()
                ->resource()
                ->withItem($user, new UserTransformer);
    }

    public function store(EmployeeRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-staff');
       
        $companyId = $currentUser->getCompanyId();
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->saveForOwner($dataInput, $companyId);
        

        return $this->response()->created();
    }

    public function update($id, EmployeeRequest $request)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-staff');
       
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);

        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-staff');
       
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);

        $this->repo()->destroyForOwner($decodedId, $owner);

        return $this->response()->deleted();
   }
}
