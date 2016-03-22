<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Requests\TaxDiscountRequest;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Interfaces\CurrentUser;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Tax;

class TaxesController extends TempApiController
{
   use Showable, Storable, Updateable, Destroyable;
   
    public function __construct(CurrentUser $user, ApiRespond $response, TaxTransformer $transformer) 
    {
       parent::__construct($user, $response, $transformer);
    }
   

    public function getRepo()
    {
        $queryType = new EloquentCompany(new Tax, $this->currentUser->getCompanyId());
        
        return new TempEloquentRepository($queryType);
    }
    
    public function getFactory()
    {
        $queryType = new EloquentCompany(new Tax, $this->currentUser->getCompanyId());
        
        return new EloquentFactory($queryType);
    }

    public function initializeAccess() 
    {
        $this->indexAccess = 'read-tax';
        $this->showAccess = 'read-tax';
        $this->deleteAccess = 'delete-tax';
        
        $this->storeAccess = 'create-tax';
        $this->updateAccess = 'update-tax';
    }

    public function request() 
    {
        return new TaxDiscountRequest;
    }

}
