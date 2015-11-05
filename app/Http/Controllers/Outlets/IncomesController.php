<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;
use Sikasir\Outlets\OutletRepository;

class IncomesController extends ApiController
{
    protected $repo;
    
    public function __construct(\Sikasir\Traits\ApiRespond $respond, OutletRepository $repo) {
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
       
       return $this->response->withPaginated($incomes, new IncomeTransformer);
       
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
