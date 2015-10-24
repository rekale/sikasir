<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\OutcomeTransformer;
use Sikasir\Finances\Outcome;

class OutletOutcomeController extends ApiController
{
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {
       
       $incomes = Outcome::whereOutletId($outletId)->paginate();
       
       return $this->respondWithPaginated($incomes, new OutcomeTransformer);
       
   }
   
   public function store($outletId)
   {
       Outcome::create([
           'id' => \Ramsey\Uuid\Uuid::uuid4()->getHex(),
           'outlet_id' => $outletId,
           'total' => $this->request()->input('total'),
           'note' => $this->request()->input('note'),
       ]);
       
       return $this->respondCreated('new income has created');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $income = Outcome::whereOutletId($outletId)->whereId($incomeId)->get();
        
        if(! $income) {
            return $this->respondNotFound('income not found');
        }
        
        Outcome::destroy($income[0]->id);
        
        return $this->respondSuccess('selected income has deleted');
    }
   
}
