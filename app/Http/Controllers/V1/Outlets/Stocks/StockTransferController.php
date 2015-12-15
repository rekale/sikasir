<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Repositories\OutletRepository;
use Sikasir\V1\Transformer\OutletTransformer;
use Sikasir\Http\Requests\OutletRequest;
use Tymon\JWTAuth\JWTAuth;
use \Sikasir\V1\Traits\ApiRespond;

class StockTransferController extends ApiController
{

    public function __construct(ApiRespond $respond, OutletRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
        $this->authorizing('read-outlet');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $outlets = $this->repo()->getPaginatedForOwner($owner);

        return $this->response()
                ->resource()
                ->withPaginated($outlets, new OutletTransformer);
    }

    public function show($id)
    {
        $this->authorizing('read-outlet');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $decodedId = $this->decode($id);
        
        $outlet = $this->repo()->findForOwner($decodedId, $owner);

        return $this->response()
                ->resource()
                ->withItem($outlet, new OutletTransformer);
    }

    public function store(OutletRequest $request)
    {
        $this->authorizing('create-outlet');

        $owner = $this->auth()->toUser()->toOwner();
        
        $dataInput = $request->all();
        
        $dataInput['business_field_id'] = $this->decode($dataInput['business_field_id']);
        
        $this->repo()->saveForOwner($dataInput, $owner);

        return $this->response()->created();
    }

    public function update($id, OutletRequest $request)
    {
        $this->authorizing('update-outlet');
        
        $owner = $this->auth()->toUser()->toOwner();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['business_field_id'] = $this->decode($dataInput['business_field_id']);

        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-outlet');
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyForOwner($decodedId);

        return $this->response()->deleted();
    }
}
