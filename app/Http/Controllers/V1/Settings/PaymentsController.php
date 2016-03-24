<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Requests\PaymentRequest;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\PaymentTransformer;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Transactions\Payment;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Interfaces\CurrentUser;
use Sikasir\V1\Repositories\Settings\PaymentRepository;

class PaymentsController extends TempApiController
{
    use Showable, Storable, Updateable, Destroyable;
   
    
    public function __construct(CurrentUser $user, ApiRespond $response) 
    {
       parent::__construct($user, $response);
    }

    public function getRepo()
    {
        $queryType = new EloquentCompany(new Payment, $this->currentUser->getCompanyId());
        
        return new TempEloquentRepository($queryType);
    }
    
    public function getFactory()
    {
        $queryType = new EloquentCompany(new Payment, $this->currentUser->getCompanyId());
        
        return new EloquentFactory($queryType);
    }

    public function initializeAccess() 
    {
        $this->showAccess = 'read-payment';
        $this->deleteAccess = 'delete-payment';
        
        $this->storeAccess = 'create-payment';
        $this->updateAccess = 'update-payment';
    }

    public function getRequest() 
    {
        return app(PaymentRequest::class);
    }
    
    public function getTransformer()
    {
    	return new PaymentTransformer;
    }

}
