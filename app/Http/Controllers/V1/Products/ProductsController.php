<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Transformer\ProductTransformer;
use Sikasir\Http\Requests\ProductRequest;

class ProductsController extends ApiController
{
  public function __construct(ApiRespond $respond, ProductRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function show($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
       
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($id);
        
        $product = $this->repo()->findWith($decodedId, $with);

        return $this->response()
                ->resource()
                ->including($with)
                ->withItem($product, new ProductTransformer);
    }

    public function store(ProductRequest $request)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-product');
       
        $owner = $currentUser->getOwnerId();
        
        $dataInput = $request->all();
        
        $dataInput['category_id'] = $this->decode($dataInput['category_id']);
        $dataInput['outlet_ids'] = $this->decode($dataInput['outlet_ids']);
        
        $this->repo()->saveForOwner($dataInput, $owner);

        return $this->response()->created();
    }

    public function update($id, ProductRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $owner = $currentUser->getOwnerId();
        
        $decodedId = $this->decode($id);
        
        $dataInput = $request->all();
        
        $dataInput['category_id'] = $this->decode($dataInput['category_id']);
        
        foreach ($dataInput['variants'] as &$variant) {
            
            if ( isset($variant['id']) ) {
                $variant['id'] = $this->decode($variant['id']);
            }
            
        }
        
        $this->repo()->updateForOwner($decodedId, $dataInput, $owner);

        return $this->response()->updated();
    }

    public function destroy($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-product');
       
        $owner = $currentUser->getOwnerId();
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyForOwner($decodedId, $owner);

        return $this->response()->deleted();
    }
}
