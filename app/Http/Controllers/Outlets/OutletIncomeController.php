<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;
use Sikasir\Outlets\OutletRepository;

class OutletIncomeController extends ApiController
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
       $incomes = $this->repo->getIncomes($outletId);
       
       return $this->respondWithPaginated($incomes, new IncomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo->saveIncome($outletId, [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
       ]);
       
       return $saved ? $this->respondCreated('new income has created') : 
           $this->respondCreateFailed('fail to create income');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $this->repo->destroyIncome($outletId, $incomeId);
                
        return $this->respondSuccess('selected income has deleted');
    }
   
}
