<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\PrinterRequest;
use Sikasir\V1\Repositories\PrinterRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class PrintersController extends ApiController
{
    
    public function __construct(ApiRespond $respond, PrinterRepository $repo, JWTAuth $auth) 
    {
        parent::__construct($respond, $auth, $repo);
    }
    
    /**
     * 
     * @param string $id
     */
   public function store($outletId, PrinterRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $throughId = $this->decode($outletId);
        
        $this->repo()->saveForOwnerThrough($request->all(), $companyId, $throughId, 'outlets');
       
       return $this->response()->created();
   }
   
   public function update($outletId, $printerId, PrinterRequest $request)
   {
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $throughId = $this->decode($outletId);
        
        $decodedId = $this->decode($printerId);
        
        $this->repo()->updateForOwnerThrough(
            $decodedId, $request->all(), $companyId, $throughId, 'outlets'
        );
       
       return $this->response()->updated();
   }
   
    public function destroy($outletId, $printerId)
    {
        
        $currentUser =  $this->currentUser();
        
        $companyId = $currentUser->getCompanyId();
        
        $throughId = $this->decode($outletId);
        
        $decodedId = $this->decode($printerId);
        
        $this->repo()->destroyForOwnerThrough(
            $decodedId, $companyId, $throughId, 'outlets'
        );
                
        return $this->response()->deleted();
    }
   
}
