<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class OutletsController extends ApiController
{
    
    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {
        
        parent::__construct($respond, $auth, $repo);
        
    }
    
    public function index()
    {
        $this->authorizing('read-outlet');
        
        $outlets = $this->repo()->getPaginated();

        return $this->response()->withPaginated($outlets, new OutletTransformer);
    }
    
    public function show($outletId)
    {
        $this->authorizing('read-outlet');
     
        $outlet = $this->repo()->find($outletId);
        
        return $this->response()->withItem($outlet, new OutletTransformer);
    }
    
    public function store(OutletRequest $request)
    {       
        $this->authorizing('create-outlet');
        
        $this->repo()->saveForOwner($request->all(), $this->auth()->toUser()->userable);
        
        return $this->response()->created();
    }
    
    public function update($id, OutletRequest $request)
    {       
        $this->authorizing('update-outlet');
        
        $this->repo()->update($request->all(), $id);
        
        return $this->response()->updated();
    }
    
    public function destroy($id)
    {       
        $this->authorizing('delete-outlet');
        
        $this->repo()->destroy($id);
        
        return $this->response()->deleted();
    }
}
