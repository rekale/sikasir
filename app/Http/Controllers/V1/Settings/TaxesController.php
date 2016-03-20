<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\TaxDiscountRequest;
use Sikasir\V1\Repositories\Settings\TaxRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Controllers\V1\Traits\Gettable;
use Sikasir\Http\Controllers\V1\Traits\PostAndUpdateable;
use Sikasir\V1\User\EloquentUser;
use Sikasir\V1\Transformer\TaxTransformer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Outlets\Tax;

class TaxesController extends TempApiController
{
   use Gettable, PostAndUpdateable;
   
    public function __construct(EloquentUser $user, ApiRespond $response, TaxTransformer $transformer) 
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
        
        $this->createAccess = 'create-tax';
        $this->updateAccess = 'update-tax';
    }

    public function request() 
    {
        return new TaxDiscountRequest;
    }

}
