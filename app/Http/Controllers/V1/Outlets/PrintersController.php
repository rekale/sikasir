<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\Http\Requests\PrinterRequest;
use Sikasir\V1\Repositories\PrinterRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Controllers\TempApiController;
use Sikasir\V1\Repositories\EloquentThroughCompany;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Outlets\Printer;
use Sikasir\V1\Repositories\TempEloquentRepository;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Commands\GeneralCreateCommand;
use Sikasir\V1\Commands\GeneralUpdateCommand;
use Sikasir\V1\Transformer\PrinterTransformer;

class PrintersController extends TempApiController
{
   	
	public function initializeAccess()
	{
		$this->storeAccess = 'read-outlet';
		$this->showAccess = 'read-outlet';
		$this->updateAccess = 'update-outlet';
		$this->destroyAccess = 'delete-outlet';
	}
	
	public function getQueryType($throughId = null)
	{
		return  new EloquentThroughCompany(
			new Printer, $this->auth->getCompanyId(), 'outlets', $throughId
		);
	}
	
	public function getRepository($throughId = null)
	{
		return new TempEloquentRepository($this->getQueryType($throughId));
	}
	
	public function getFactory($throughId = null)
	{
		return new EloquentFactory($this->getQueryType($throughId));
	}
	
	public function createCommand($throughId = null)
	{
		return new GeneralCreateCommand($this->getFactory($throughId));
	}
	
	public function updateCommand($throughId = null)
	{
		return new GeneralUpdateCommand($this->getRepository($throughId));
	}
	public function getSpecificRequest()
	{
		return app(PrinterRequest::class);
	}
	
	
	public function getTransformer()
	{
		return new PrinterTransformer;
	}
	
	public function getReportTransformer()
	{
		return new PrinterTransformer;
	}
	
	
	public function getReport($throughId = null)
	{
		throw new \Exception('not implemented');
	}
    /**
     * 
     * @param string $id
     
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
   */
}
