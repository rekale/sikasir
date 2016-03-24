<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Interfaces\CurrentUser;
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

class OutletsController extends TempApiController
{
    
   use Indexable, Showable, Storable, Updateable, Destroyable;
    
    public function __construct(CurrentUser $user, ApiRespond $response) 
    {
        parent::__construct($user, $response);
        
    }  

    public function getRepo()
    {
        $queryType = new EloquentCompany(new Outlet, $this->currentUser->getCompanyId());
        
        return new TempEloquentRepository($queryType);
    }
    
    public function getFactory()
    {
        $queryType = new EloquentCompany(new Outlet, $this->currentUser->getCompanyId());
        
        return new EloquentFactory($queryType);
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

}
