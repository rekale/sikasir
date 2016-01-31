<?php

namespace Sikasir\Http\Controllers\V1\Suppliers;

use \Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Sikasir\V1\Repositories\SupplierRepository;
use Sikasir\Http\Requests\SupplierRequest;
use Sikasir\V1\Transformer\SupplierTransformer;

class SuppliersController extends ApiController
{

    public function __construct(ApiRespond $respond, JWTAuth $auth, SupplierRepository $repo)
    {
        parent::__construct($respond, $auth, $repo);
    }

    public function index()
    {
        $currentUser = $this->currentUser();
        
        $this->authorizing($currentUser, 'read-supplier');
        
        $paginator = $this->repo()->getPaginatedForOwner(
            $currentUser->getCompanyId()
        );
        
        return $this->response()
                ->resource()
                ->withPaginated($paginator, new SupplierTransformer);
    }

    public function show($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-supplier');
       
        $owner = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $supplier = $this->repo()->findFOrOwner($decodedId, $owner);

        return $this->response()
                ->resource()
                ->withItem($supplier, new SupplierTransformer);
    }

    public function store(SupplierRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-supplier');
       
        $ownerId = $currentUser->getCompanyId();
        
        $dataInput = $request->all();
        
        $this->repo()->saveForOwner($dataInput, $ownerId);
        

        return $this->response()->created();
    }

    public function update($id, SupplierRequest $request)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-supplier');
       
        $ownerId = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();

        $this->repo()->updateForOwner($decodedId, $dataInput, $ownerId);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-supplier');
       
        $ownerId = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);

        $this->repo()->destroyForOwner($decodedId, $ownerId);

        return $this->response()->deleted();
   }
}
