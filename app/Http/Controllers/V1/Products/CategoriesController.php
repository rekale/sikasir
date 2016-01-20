<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Transformer\CategoryTransformer;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
  public function __construct(ApiRespond $respond, ProductRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
       
        $owner = $currentUser->getOwnerId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $categories = $this->repo()->getCategories($owner);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($categories, new CategoryTransformer);
    }

    
    public function store(Request $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-product');
       
        $owner = $currentUser->getOwnerId();
        
        $this->repo()->saveCategory($owner, $request->input('name'));

        return $this->response()->created();
    }
    
    public function update($id, Request $request)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $owner = $currentUser->getOwnerId();
        
        $this->repo()->updateCategory($owner, $this->decode($id), $request->input('name'));
        
        return $this->response()->updated();
    }

    public function destroy($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-product');
       
        $owner = $currentUser->getOwnerId();
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyCategories($owner, $decodedId);

        return $this->response()->deleted();
    }
}
