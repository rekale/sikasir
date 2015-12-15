<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\V1\Transformer\IncomeTransformer;
use Sikasir\V1\Repositories\OutletRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class IncomesController extends ApiController
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
       $incomes = $this->repo()->getIncomes($this->decode($outletId));
       
       return $this->response()
               ->resource()
               ->withPaginated($incomes, new IncomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo()->saveIncome($this->decode($outletId), [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
       ]);
       
       return $saved ? $this->response()->created('new income has created') : 
           $this->response()->createFailed('fail to create income');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $this->repo()->destroyIncome($this->decode($outletId), $this->decode($outletId));
                
        return $this->response()->deleted('selected income has deleted');
    }
   
}
