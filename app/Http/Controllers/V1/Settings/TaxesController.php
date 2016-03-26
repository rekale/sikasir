<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class TaxesController extends TempApiController implements
												Resourcable,
												manipulatable
{
   use Showable, Storable, Updateable, Destroyable;
   
   public function getQueryType()
   {
   	return new EloquentCompany(new Tax, $this->auth->getCompanyId());
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
        $this->indexAccess = 'read-tax';
        $this->showAccess = 'read-tax';
        $this->deleteAccess = 'delete-tax';
        
        $this->storeAccess = 'create-tax';
        $this->updateAccess = 'update-tax';
        
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
    
    public function getRequest() 
    {
        return app(TaxDiscountRequest::class);
    }
    
    public function getTransformer()
    {
    	return new TaxTransformer;
    }

}
