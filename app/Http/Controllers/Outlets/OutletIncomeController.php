<?php

namespace Sikasir\Http\Controllers\Outlets;

use Sikasir\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Outlet;
use Sikasir\Transformer\IncomeTransformer;
use Sikasir\Finances\Income;
use Sikasir\Outlets\OutletRepository;

class OutletIncomeController extends Controller
{
    protected $repo;
    protected $req;
    
    public function __construct(OutletRepository $repo, Request $request, \League\Fractal\Manager $fractal) {
        $this->repo = $repo;
        $this->req = $request;
        $this->setFractal($fractal);
        
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
   
   public function store($outletId)
   {
       $saved = $this->repo->saveIncome($outletId, [
          'total' => $this->req->input('total'),
          'note' => $this->req->input('note'), 
       ]);
       
       return $saved ? $this->respondCreated('new income has created') : 
           $this->setStatusCode(409)->respondWithError('fail to create income');
   }
   
    public function destroy($outletId, $incomeId)
    {
        
        $this->repo->destroyIncome($outletId, $incomeId);
                
        return $this->respondSuccess('selected income has deleted');
    }
   
}
