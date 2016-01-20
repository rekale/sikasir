<?php

namespace Sikasir\Http\Controllers\V1\Cashiers;


use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\CashierRepository;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Transformer\CashierTransformer;
use Sikasir\Http\Requests\CashierRequest;
use League\Fractal\Manager;

class CashiersController extends ApiController
{

    public function __construct(ApiRespond $respond, JWTAuth $auth, CashierRepository $repo) 
    {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-cashier');
       
        $paginator = $this->repo()->getPaginatedForOwner(
           $currentUser->getOwnerId()
        );

        return $this->response()
                ->resource()
                ->withPaginated($paginator, new CashierTransformer);
    }

    public function show($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-cashier');
       
        $owner = $currentUser->getOwnerId();
        
        $decodedId = $this->decode($id);
        
        $user = $this->repo()->findForOwner($decodedId, $owner);

        return $this->response()
                ->resource()
                ->withItem($user, new CashierTransformer);
    }

    public function store(CashierRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-cashier');
       
        $owner = $currentUser->getOwnerId();
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->saveForOwner($dataInput, $owner);
        
        return $this->response()->created();
    }

    public function update($id, CashierRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-cashier');
       
        $owner = $currentUser->getOwnerId();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-cashier');
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroy($decodedId);

        return $this->response()->deleted();
   }
}
