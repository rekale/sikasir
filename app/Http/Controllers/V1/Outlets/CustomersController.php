<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;

class CustomersController extends ApiController
{
    
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {
        
        parent::__construct($respond, $auth, $repo);
    
    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       $customers = $this->repo()->getCustomers($outletId);
       
       return $this->response()
               ->resource()
               ->withPaginated($customers, new CustomerTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo()->saveCustomer($outletId, [
            'name' => $request->input('name'),
            'email' => $request->input('email'), 
            'sex' => $request->input('sex'), 
            'phone' => $request->input('phone'), 
            'address' => $request->input('address'), 
            'city' => $request->input('city'), 
            'pos_code' => $request->input('pos_code'),
       ]);
       
       return $saved ? $this->respondCreated('new customer has created') : 
           $this->response()->setStatusCode(409)->withError('fail to create customer');
   }
   
    public function destroy($outletId, $customerId)
    {
        
        $this->repo()->destroyCustomer($outletId, $customerId);
                
        return $this->response()->success('selected customer has deleted');
    }
   
}
