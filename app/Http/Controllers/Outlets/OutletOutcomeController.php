<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\Controller;
use Sikasir\Outlet;
use Sikasir\Transformer\OutcomeTransformer;
use Sikasir\Finances\Outcome;
use League\Fractal\Manager;
use Sikasir\Outlets\OutletRepository;

class OutletOutcomeController extends Controller
{
    protected $repo;
    protected $req;
    
    public function __construct(OutletRepository $repo, Request $request, Manager $fractal) {
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
       $outcomes = $this->repo->getOutcomes($outletId);
       
       return $this->respondWithPaginated($outcomes, new OutcomeTransformer);
       
   }
   
   public function store($outletId)
   {
       $saved = $this->repo->saveOutcome($outletId, [
          'total' => $this->req->input('total'),
          'note' => $this->req->input('note'), 
       ]);
       
       return $saved ? $this->respondCreated('new outcome has created') : 
           $this->respondCreateFailed('fail to create outcome');
   }
   
    public function destroy($outletId, $outcomeId)
    {
        
        $this->repo->destroyOutcome($outletId, $outcomeId);
                
        return $this->respondSuccess('selected outcome has deleted');
    }
}
