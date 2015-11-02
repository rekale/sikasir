<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\CustomerTransformer;
use Sikasir\Finances\Customer;
use Sikasir\Outlets\OutletRepository;

class OutletCustomerController extends Controller
{
    protected $repo;
    protected $req;
    
    public function __construct(OutletRepository $repo, Request $request, \League\Fractal\Manager $fractal) {
        $this->repo = $repo;
        $this->req = $request;
        $this->setFractal($fractal);
        
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
   
   public function store($outletId)
   {
       $saved = $this->repo->saveCustomer($outletId, [
            'name' => $this->req->input('name'),
            'email' => $this->req->input('email'), 
            'sex' => $this->req->input('sex'), 
            'phone' => $this->req->input('phone'), 
            'address' => $this->req->input('address'), 
            'city' => $this->req->input('city'), 
            'pos_code' => $this->req->input('pos_code'),
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
