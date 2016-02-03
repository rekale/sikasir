<?php

namespace Sikasir\Http\Controllers\V1\Customers;

use Sikasir\Http\Requests\CustomerRequest;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\V1\Repositories\CustomerRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Sikasir\V1\Transformer\CustomerHistoryTransformer;

class CustomersController extends ApiController
{
    
    public function __construct(ApiRespond $respond, CustomerRepository $repo, JWTAuth $auth) {
        
        parent::__construct($respond, $auth, $repo);
    
    }
    
    /**
     * 
     * @param string $id
     */
   public function index()
   {    
       $currentUser = $this->currentUser();
        
       $this->authorizing($currentUser, 'read-customer');
       
       $companyId = $currentUser->getCompanyId();
       
       $customers = $this->repo()->getPaginatedForOwner($companyId);
       
       return $this->response()
               ->resource()
               ->withPaginated($customers, new CustomerTransformer);
       
   }
   
   public function show($id)
   {    
       $currentUser = $this->currentUser();
        
       $this->authorizing($currentUser, 'read-customer');
       
       $companyId = $currentUser->getCompanyId();
       
       $customers = $this->repo()->findForOwner($companyId, $this->decode($id));
       
       return $this->response()
               ->resource()
               ->withItem($customers, new CustomerTransformer);
       
   }
   
   public function store(CustomerRequest $request)
   {
       $currentUser = $this->currentUser();
        
       $this->authorizing($currentUser, 'read-customer');
       
       $companyId = $currentUser->getCompanyId();
       
       $dataInput = $request->all();
       
       $this->repo()->saveForOwner($request->all(), $companyId);
       
       return $this->response()->created();
   }
   
      public function update($id, CustomerRequest $request)
   {
       $currentUser = $this->currentUser();
        
       $this->authorizing($currentUser, 'update-customer');
       
       $companyId = $currentUser->getCompanyId();
       
       $decodedId = $this->decode($id);
       
       $this->repo()->updateForOwner($decodedId, $request->all(), $companyId);
       
       return $this->response()->created();
   }
   
    public function destroy($id)
    {
        $currentUser = $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-customer');

        $companyId = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyForOwner($decodedId, $companyId);
                
        return $this->response()->success('selected customer has deleted');
    }
    
    public function transactionHistories($id, $dateRange, Request $request)
    {
        $currentUser = $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-customer');

        $companyId = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $data = $this->repo()->getHistoryTransactionForCompany($decodedId, $companyId, $dateRange);
        
        return $this->response()
                ->resource()
                ->withCollection($data, new CustomerHistoryTransformer);
    }
   
}
