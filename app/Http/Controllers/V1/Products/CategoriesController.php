<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Transformer\CategoryTransformer;
use Sikasir\Http\Requests\CategoryRequest;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Products\Category;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class CategoriesController extends TempApiController implements
													Resourcable,
													manipulatable
{
    
   use Showable, Storable, Updateable, Destroyable;
   
   public function getQueryType($throughId = null)
   {
   		return new EloquentCompany(new Category, $this->auth->getCompanyId());
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
        $this->indexAccess = 'read-category';
        $this->showAccess = 'read-category';
        $this->deleteAccess = 'delete-category';
        
        $this->storeAccess = 'create-category';
        $this->updateAccess = 'update-category';
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
        return app(CategoryRequest::class);
    }
    
    public function getTransformer()
    {
    	return new CategoryTransformer;
    }
}
