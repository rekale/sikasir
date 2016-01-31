<?php

namespace Sikasir\Http\Controllers\V1\Outlets\Stocks;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\Inventories\OutRepository;
use Sikasir\V1\Transformer\InventoryTransformer;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\Http\Requests\InventoryRequest;

class OutsController extends ApiController
{

    public function __construct(ApiRespond $respond, OutRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index($outletId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-inventory');
        
        $ownerId = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($outletId);
        
        $stocks = $this->repo()->getPaginatedForOwnerThrough('outlets', $ownerId, $decodedId, $with);
        
        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($stocks, new InventoryTransformer);
    }
    
    public function store($outletId, InventoryRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-inventory');
        
        $companyId = $currentUser->getCompanyId();
        
        $dataInput = $request->all();
        
        $dataInput['user_id'] = $this->decode($dataInput['user_id']);
        
        foreach($dataInput['variants'] as &$variant) {
            $variant['id'] = $this->decode($variant['id']);
        }
        
        $this->repo()->saveForOwnerThrough($dataInput, $companyId, $this->decode($outletId), 'outlets');
        
        return $this->response()->created();
    }

    
}
