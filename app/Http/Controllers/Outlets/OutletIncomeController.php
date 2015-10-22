<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;
use Sikasir\Finances\Income;

class OutletIncomeController extends ApiController
{
    /**
     * 
     * @param integer $id
     */
   public function index($outletId)
   {
       $outlet = Outlet::with('incomes')->find($outletId);
       
       if (! $outlet) {
           return $this->respondNotFound('outlet not found');
       }
       
       $incomes = $outlet->incomes()->paginate();
       
       return $this->respondWithPaginated($incomes, new IncomeTransformer);
       
   }
   
   public function store($outletId)
   {
       $outlet = Outlet::find($outletId);
       
       if (! $outlet) {
           return $this->respondNotFound('outlet not found');
       }
       
       $income = new Income([
           'total' => $this->request()->input('total'),
           'note' => $this->request()->input('note'),
       ]);
       
       $outlet->incomes()->save($income);
       
       return $this->respondCreated('new income has created');
   }
   
    public function destroy($outletId, $incomeId)
    {
        $outlet = Outlet::find($outletId);
        
        if(! $outlet) {
            return $this->respondNotFound('outlet not found');
        }
        
        $income = $outlet->incomes()->find($incomeId);
        
        if(! $income) {
            return $this->respondNotFound('income not found');
        }
        
        $income->delete();
        
        return $this->respondSuccess('selected income has deleted');
    }
   
}
