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
        $this->authorizing('read-product');
        
        $owner = $this->currentUser()->toOwner();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $categories = $this->repo()->getCategories($owner);

        return $this->response()
                ->resource()
                ->including($include)
                ->withPaginated($categories, new CategoryTransformer);
    }

    
    public function store(Request $request)
    {
        $this->authorizing('create-product');
        
        $owner = $this->currentUser()->toOwner();
        
        $this->repo()->saveCategory($owner, $request->input('name'));

        return $this->response()->created();
    }
    
    public function update($id, Request $request)
    {
        $this->authorizing('update-product');

        $owner = $this->currentUser()->toOwner();
        
        $this->repo()->updateCategory($owner, $this->decode($id), $request->input('name'));
        
        return $this->response()->updated();
    }

    public function destroy($id)
    {
        $this->authorizing('delete-product');
        
        $decodedId = $this->decode($id);
        
        $owner = $this->currentUser()->toOwner();
        
        $this->repo()->destroyCategories($owner, $decodedId);

        return $this->response()->deleted();
    }
}
