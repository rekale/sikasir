<?php

namespace Sikasir\Http\Controllers\V1\Employees;

use Sikasir\V1\Transformer\UserTransformer;
use Sikasir\Http\Requests\EmployeeRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\Http\Controllers\V1\Traits\Indexable;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\User\User;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\User\Authorizer;
use Sikasir\V1\Util\Obfuscater;

class EmployeesController extends TempApiController implements
													Resourcable,
													manipulatable
{
	
	use Indexable, Showable, Destroyable, Storable;
	
	public function getQueryType($throughId = null)
	{
		return 	new EloquentCompany(new User, $this->auth->getCompanyId());
	}
	
 
    public function getRepo()
    {   
        return new TempEloquentRepository($this->getQueryType());
    }
    
    public function getFactory()
    {
        return new EloquentFactory($this->getQueryType());
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


	public function createJob(array $data)
	{
		\DB::beginTransaction();
			
		try {
			
			$factory = new EloquentFactory($this->getQueryType());
			
			$user = $factory->create($data);
			
			(new Authorizer($user))->giveAccess($data['privileges']);
				
			$outletIds = Obfuscater::decode($data['outlet_id']);
				
			$user->outlets()->attach($outletIds);
				
		
		}
		catch (\Exception $e) {
			
			\DB::rollback();
			
		}
		
		\DB::commit();
		
		
	}
	
	public function updateJob($id , array $data)
	{
		$repo = $this->getRepo();
		 
		$user = $repo->find($id);
		 
		$user->update($data);
		
		(new Authorizer($user))->syncAccess($data['privileges']);
		
		$outletIds = Obfuscater::decode($data['outlet_id']);
		
		$user->outlets()->sync($outletIds);
	}

}
