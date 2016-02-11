<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Illuminate\Http\Request;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\OutcomeTransformer;
use Sikasir\V1\Repositories\OutletRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;


class OutcomesController extends ApiController
{
    
   public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    /**
     * 
     * @param string $id
     */
   public function index($outletId)
   {    
       $outcomes = $this->repo()->getOutcomes($this->decode($outletId));
       
       return $this->response()
               ->resource()
               ->withPaginated($outcomes, new OutcomeTransformer);
       
   }
   
   public function store($outletId, Request $request)
   {
       $saved = $this->repo()->saveOutcome($outletId, [
          'total' => $request->input('total'),
          'note' => $request->input('note'), 
       ]);
       
       return $saved ? $this->response()->created('new outcome has created') : 
           $this->response()->createFailed('fail to create outcome');
   }
   
    public function destroy($outletId, $outcomeId)
    {
        
        $this->repo()->destroyOutcome($this->decode($outletId), $this->decode($outcomeId));
                
        return $this->response()->deleted('selected outcome has deleted');
    }
}
