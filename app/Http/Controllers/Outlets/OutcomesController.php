<?php

namespace Sikasir\Http\Controllers\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\Transformer\OutcomeTransformer;
use League\Fractal\Manager;
use Sikasir\Outlets\OutletRepository;

class OutcomesController extends ApiController
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
       $outcomes = $this->repo->getOutcomes($outletId);
       
       return $this->response->withPaginated($outcomes, new OutcomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo->saveOutcome($outletId, [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
       ]);
       
       return $saved ? $this->response->created('new outcome has created') : 
           $this->response->createFailed('fail to create outcome');
   }
   
    public function destroy($outletId, $outcomeId)
    {
        
        $this->repo->destroyOutcome($outletId, $outcomeId);
                
        return $this->response->success('selected outcome has deleted');
    }
}
