<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Interfaces\CurrentUser;
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

class CategoriesController extends TempApiController
{
    
   use Showable, Storable, Updateable, Destroyable;
   
    public function __construct(CurrentUser $user, ApiRespond $response) 
    {
       parent::__construct($user, $response);
    }
   

    public function getRepo()
    {
        $queryType = new EloquentCompany(new Category, $this->currentUser->getCompanyId());
        
        return new TempEloquentRepository($queryType);
    }
    
    public function getFactory()
    {
        $queryType = new EloquentCompany(new Category, $this->currentUser->getCompanyId());
        
        return new EloquentFactory($queryType);
    }

    public function initializeAccess() 
    {
        $this->indexAccess = 'read-category';
        $this->showAccess = 'read-category';
        $this->deleteAccess = 'delete-category';
        
        $this->storeAccess = 'create-category';
        $this->updateAccess = 'update-category';
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
