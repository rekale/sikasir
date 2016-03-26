<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\TempApiController;
use Sikasir\Http\Requests\PaymentRequest;
use Sikasir\V1\Transformer\PaymentTransformer;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Transactions\Payment;
use Sikasir\Http\Controllers\V1\Traits\Showable;
use Sikasir\Http\Controllers\V1\Traits\Storable;
use Sikasir\Http\Controllers\V1\Traits\Updateable;
use Sikasir\Http\Controllers\V1\Traits\Destroyable;
use Sikasir\V1\Repositories\EloquentCompany;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\Http\Controllers\V1\Interfaces\Resourcable;
use Sikasir\Http\Controllers\V1\Interfaces\manipulatable;

class PaymentsController extends TempApiController implements
													Resourcable,
													manipulatable
{
    use Showable, Storable, Updateable, Destroyable;
   

    public function getQueryType()
    {
    	return new EloquentCompany(new Payment, $this->auth->getCompanyId());
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
        $this->showAccess = 'read-payment';
        $this->deleteAccess = 'delete-payment';
        
        $this->storeAccess = 'create-payment';
        $this->updateAccess = 'update-payment';
    }

    public function getRequest() 
    {
        return app(PaymentRequest::class);
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
    
    public function getTransformer()
    {
    	return new PaymentTransformer;
    }

}
