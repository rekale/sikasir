<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Transformer\OutcomeTransformer;
use League\Fractal\Manager;
use Sikasir\Outlets\OutletRepository;

class OutletOutcomeController extends ApiController
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
       $outcomes = $this->repo->getOutcomes($outletId);
       
       return $this->respondWithPaginated($outcomes, new OutcomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo->saveOutcome($outletId, [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
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
