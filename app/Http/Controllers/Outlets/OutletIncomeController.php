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
     * @param string $id
     */
   public function index($outletId)
   {
       
       $incomes = Income::whereOutletId($outletId)->paginate();
       
       return $this->respondWithPaginated($incomes, new IncomeTransformer);
       
   }
   
   public function store($outletId)
   {
       Income::create([
           'id' => \Ramsey\Uuid\Uuid::uuid4()->getHex(),
           'outlet_id' => $outletId,
           'total' => $this->request()->input('total'),
           'note' => $this->request()->input('note'),
       ]);
       
       return $this->respondCreated('new income has created');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $income = Income::whereOutletId($outletId)->whereId($incomeId)->get();
        
        if(! $income) {
            return $this->respondNotFound('income not found');
        }
        
        Income::destroy($income[0]->id);
        
        return $this->respondSuccess('selected income has deleted');
    }
   
}
