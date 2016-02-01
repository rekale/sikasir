<?php

namespace Sikasir\Http\Controllers\V1\Settings;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\PaymentRequest;
use Sikasir\V1\Repositories\Settings\PaymentRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class PaymentsController extends ApiController
{
    
    public function __construct(ApiRespond $respond, PaymentRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }
    
   public function store(PaymentRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->saveForOwner($request->all(), $companyId);
       
       return $this->response()->created();
   }
   
   public function update($id, PaymentRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->updateForOwner($this->decode($id), $request->all(), $companyId);
       
       return $this->response()->created();
   }
   
    public function destroy($id)
    {
        
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->destroyForOwner($this->decode($id), $companyId);
                
        return $this->response()->deleted();
    }
   
}
