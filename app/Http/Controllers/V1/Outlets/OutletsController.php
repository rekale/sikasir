<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\Http\Controllers\V1\Traits\Indexable;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class OutletsController extends TempApiController implements 
												Resourcable,
												manipulatable
{
    
   use Indexable, Showable, Storable, Updateable, Destroyable;
    

   public function getQueryType()
   {
   		return new EloquentCompany(new Outlet, $this->auth->getCompanyId());
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
        $this->indexAccess = 'read-outlet';
        $this->showAccess = 'read-specific-outlet';
        $this->deleteAccess = 'delete-outlet';
        
        $this->storeAccess = 'create-outlet';
        $this->updateAccess = 'update-outlet';
    }

    public function getRequest() 
    {
        return app(OutletRequest::class);
    }
    
    public function getTransformer()
    {
    	return new OutletTransformer;
    }
    
    public function createJob(array $data)
    {
    	$factory = new EloquentFactory($this->getQueryType());
    	
    	$factory->create($data);
    }
    
    public function updateJob($id, array $data)
    {
    	$repo = $this->getRepo();
    	
    	$entity = $repo->find($id);
    	
    	$entity->update($data);
    }

}
