<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Outlet;
use Sikasir\V1\Transformer\CustomerTransformer;
use Sikasir\V1\Finances\Customer;
use Sikasir\V1\Outlets\OutletRepository;

class CustomersController extends ApiController
{
    
    protected $repo;
    
    public function __construct(\Sikasir\V1\Traits\ApiRespond $respond, OutletRepository $repo) {
        parent::__construct($respond);
        
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       $customers = $this->repo->getCustomers($outletId);
       
       return $this->response->withPaginated($customers, new CustomerTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo->saveCustomer($outletId, [
            'name' => $request->input('name'),
            'email' => $request->input('email'), 
            'sex' => $request->input('sex'), 
            'phone' => $request->input('phone'), 
            'address' => $request->input('address'), 
            'city' => $request->input('city'), 
            'pos_code' => $request->input('pos_code'),
       ]);
       
       return $saved ? $this->respondCreated('new customer has created') : 
           $this->response->setStatusCode(409)->withError('fail to create customer');
   }
   
    public function destroy($outletId, $customerId)
    {
        
        $this->repo->destroyCustomer($outletId, $customerId);
                
        return $this->response->success('selected customer has deleted');
    }
   
}
