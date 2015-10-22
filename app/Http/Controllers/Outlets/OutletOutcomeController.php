<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;
use Sikasir\Finances\Income;

class OutletOutcomeController extends ApiController
{
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {
       $outlet = Outlet::with('incomes')->find($outletId);
       
       if (! $outlet) {
           return $this->respondNotFound('outlet not found');
       }
       
       $outcomes = $outlet->incomes()->paginate();
       
       return $this->respondWithPaginated($outcomes, new IncomeTransformer);
       
   }
   
   public function store($outletId)
   {
       $outlet = Outlet::find($outletId);
       
       if (! $outlet) {
           return $this->respondNotFound('outlet not found');
       }
       
       $outcome = new Income([
           'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
           'total' => $this->request()->input('total'),
           'note' => $this->request()->input('note'),
       ]);
       
       $outlet->incomes()->save($outcome);
       
       return $this->respondCreated('new outcome has created');
   }
   
    public function destroy($outletId, $outcomeId)
    {
        $outlet = Outlet::find($outletId);
        
        if(! $outlet) {
            return $this->respondNotFound('outlet not found');
        }
        
        $outcome = $outlet->incomes()->find($outcomeId);
        
        if(! $outcome) {
            return $this->respondNotFound('outcome not found');
        }
        
        $outcome->delete();
        
        return $this->respondSuccess('selected outcome has deleted');
    }
   
}
