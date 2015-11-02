<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\CustomerTransformer;
use Sikasir\Finances\Customer;
use Sikasir\Outlets\OutletRepository;

class OutletCustomerController extends ApiController
{
    protected $repo;
  
    public function __construct(\League\Fractal\Manager $fractal, OutletRepository $repo) {
        parent::__construct($fractal);
        
        $this->repo = $repo;
    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       $customers = $this->repo->getCustomers($outletId);
       
       return $this->respondWithPaginated($customers, new CustomerTransformer);
       
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
           $this->setStatusCode(409)->respondWithError('fail to create customer');
   }
   
    public function destroy($outletId, $customerId)
    {
        
        $this->repo->destroyCustomer($outletId, $customerId);
                
        return $this->respondSuccess('selected customer has deleted');
    }
   
}
