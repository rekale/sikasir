<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\V1\Outlet;
use Sikasir\V1\Transformer\IncomeTransformer;
use Sikasir\V1\Repositories\OutletRepository;

class IncomesController extends ApiController
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
       $incomes = $this->repo->getIncomes($outletId);
       
       return $this->response
               ->resource()
               ->withPaginated($incomes, new IncomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo->saveIncome($outletId, [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
       ]);
       
       return $saved ? $this->response->created('new income has created') : 
           $this->response->createFailed('fail to create income');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $this->repo->destroyIncome($outletId, $incomeId);
                
        return $this->response->success('selected income has deleted');
    }
   
}
