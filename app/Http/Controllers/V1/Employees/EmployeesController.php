<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Illuminate\Http\Request;
use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\Http\Requests\EmployeeRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Interfaces\CurrentUser;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\Http\Controllers\V1\Traits\Indexable;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\User\User;
use Sikasir\V1\Factories\UserFactory;
use Sikasir\Http\Controllers\V1\Traits\Storable;

class EmployeesController extends TempApiController
{
	
	use Indexable, Showable, Destroyable, Storable;
	
 
    public function getRepo()
    {
        $queryType = new EloquentCompany(new User, $this->currentUser->getCompanyId());
        
        return new TempEloquentRepository($queryType);
    }
    
    public function getFactory()
    {
        $queryType = new EloquentCompany(new User, $this->currentUser->getCompanyId());
        
        return new UserFactory($queryType);
    }

    public function initializeAccess() 
    {
        $this->indexAccess = 'read-staff';
        $this->showAccess = 'read-specific-staff';
        $this->deleteAccess = 'delete-staff';
        
        $this->storeAccess = 'create-staff';
        $this->updateAccess = 'update-staff';
    }

    public function getRequest() 
    {
        return app(EmployeeRequest::class);
    }
    
    public function getTransformer()
    {
    	return new UserTransformer;
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

}
