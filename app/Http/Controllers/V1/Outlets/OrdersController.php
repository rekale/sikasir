<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OrderTransformer;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Repositories\OrderRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\OrderRequest;

class OrdersController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $id
     */
   public function index($id)
   {    
       
       $this->authorizing('read-order');
        
        $owner = $this->currentUser()->toOwner();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getOrdersPaginated($this->decode($id), $owner, $with);
        
        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
        
   }
   
   public function voided($id)
   {
        $this->authorizing('read-order');
        
        $owner = $this->currentUser()->toOwner();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $include = isset($include) ? $include . ',voidby' : 'voidby';
        
        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->getOrdersVoidPaginated($this->decode($id), $owner, $with);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($collection, new OrderTransformer);
        
   }
   
    public function paid($id)
    {
         $this->authorizing('read-order');

         $owner = $this->currentUser()->toOwner();

         $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

         $include = isset($include) ? $include . ',voidby' : 'voidby';

         $with = $this->filterIncludeParams($include);

         $collection = $this->repo()->getOrdersPaidPaginated($this->decode($id), $owner, $with);

         return $this->response()
                 ->resource()
                 ->including($include)
                 ->withPaginated($collection, new OrderTransformer);

    }
    
    public function unpaid($id)
    {
         $this->authorizing('read-order');

         $owner = $this->currentUser()->toOwner();

         $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

         $include = isset($include) ? $include . ',voidby' : 'voidby';

         $with = $this->filterIncludeParams($include);

         $collection = $this->repo()->getOrdersUnpaidPaginated($this->decode($id), $owner, $with);

         return $this->response()
                 ->resource()
                 ->including($include)
                 ->withPaginated($collection, new OrderTransformer);

    }
    
    public function store($id, OrderRequest $request)
    {
        $this->authorizing('create-order');

        $owner = $this->auth()->toUser()->toOwner();
        
        $dataInput = $request->all();
        
        if ( isset($dataInput['customer_id']) ) {
            $dataInput['customer_id'] = $this->decode($dataInput['customer_id']);
        }
        
        if ( isset($dataInput['discount_id']) ) {
            $dataInput['discount_id'] = $this->decode($dataInput['discount_id']);
        }
        
        $dataInput['outlet_id'] = $this->decode($id);
        
        $dataInput['operator_id'] = $this->decode($dataInput['operator_id']);
        
        $dataInput['tax_id'] = $this->decode($dataInput['tax_id']);
        
        foreach ($dataInput['items'] as &$item) {
            $item['id'] = $this->decode($item['id']);
        }
        
        $repo = app(OrderRepository::class);
        
        $repo->save($dataInput);

        return $this->response()->created();
    }

}
