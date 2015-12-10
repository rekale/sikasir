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
        $this->authorizing('read-cashier');
       
        $paginator = $this->repo()->getPaginatedForOwner(
            $this->currentUser()->toOwner()
        );

        return $this->response()
                ->resource()
                ->withPaginated($paginator, new CashierTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-cashier');
        
        $decodedId = $this->decode($id);
        
        $user = $this->repo()->findForOwner($decodedId,  $this->currentUser()->toOwner());

        return $this->response()
                ->resource()
                ->withItem($user, new CashierTransformer);
    }

    public function store(CashierRequest $request)
    {
        $this->authorizing('create-cashier');

        $owner = $this->currentUser()->toOwner();
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->saveForOwner($dataInput, $owner);
        
        return $this->response()->created();
    }

    public function update($id, CashierRequest $request)
    {
        $this->authorizing('update-cashier');
        
        $owner = $this->currentUser()->toOwner();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['outlet_id'] = $this->decode($dataInput['outlet_id']);
        
        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-cashier');
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroy($decodedId);

        return $this->response()->deleted();
   }
}
