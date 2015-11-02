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
    protected $repo;
    protected $req;
    
    public function __construct(OutletRepository $repo, Request $request) {
        $this->repo = $repo;
        $this->req = $request;
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
        
        $outcome = Outcome::whereOutletId($outletId)->whereId($outcomeId)->get();
        
        if(! $outcome) {
            return $this->respondNotFound('outcome not found');
        }
        
        Outcome::destroy($outcome[0]->id);
        
        return $this->respondSuccess('selected outcome has deleted');
    }
}
