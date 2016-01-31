<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OrderTransformer;
use Sikasir\V1\Repositories\OrderRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\OrderRequest;

class OrdersController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, OrderRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
       
        $ownerId = $currentUser->getCompanyId();
       
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getUnvoidPaginated($this->decode($outletId), $ownerId, $with);
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
        
   }
   
   public function voided($outletId)
   {
        
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
       
        $ownerId = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $include = isset($include) ? $include . ',voidby' : 'voidby';
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getVoidPaginated($this->decode($outletId), $ownerId, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
        
   }
   
    public function paid($outletId)
    {
         
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-order');
       
        $ownerId = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $include = isset($include) ? $include . ',voidby' : 'voidby';

         $with = $this->filterIncludeParams($include);

         $collection = $this->repo()->getPaidPaginated($this->decode($outletId), $ownerId, $with);

         return $this->response()
                 ->resource()
                 ->including($include)
                 ->withPaginated($collection, new OrderTransformer);

    }
    
    public function unpaid($outletId)
    {
         $this->authorizing('read-order');

         $ownerId = $this->currentUser()->getCompanyId();

         $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

         $include = isset($include) ? $include . ',voidby' : 'voidby';

         $with = $this->filterIncludeParams($include);

         $collection = $this->repo()->getUnpaidPaginated($this->decode($outletId), $ownerId, $with);

         return $this->response()
                 ->resource()
                 ->including($include)
                 ->withPaginated($collection, new OrderTransformer);

    }
    
    public function store($outletId, OrderRequest $request)
    {
        $this->authorizing('create-order');

        $ownerId = $this->auth()->toUser()->getCompanyId();
        
        $dataInput = $request->all();
        
        if ( isset($dataInput['customer_id']) ) {
            $dataInput['customer_id'] = $this->decode($dataInput['customer_id']);
        }
        
        if ( isset($dataInput['discount_id']) ) {
            $dataInput['discount_id'] = $this->decode($dataInput['discount_id']);
        }
        
        $dataInput['outlet_id'] = $this->decode($outletId);
        
        $dataInput['operator_id'] = $this->decode($dataInput['operator_id']);
        
        $dataInput['tax_id'] = $this->decode($dataInput['tax_id']);
        
        $dataInput['payment_id'] = $this->decode($dataInput['payment_id']);
        
        foreach ($dataInput['products'] as &$product) {
            $product['id'] = $this->decode($product['id']);
        }
        
        
        $this->repo()->save($dataInput);

        return $this->response()->created();
    }

}
