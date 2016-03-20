<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\CategoryRepository;
use Sikasir\V1\Transformer\CategoryTransformer;
use Sikasir\Http\Requests\CategoryRequest;

class CategoriesController extends ApiController
{
  public function __construct(ApiRespond $respond, CategoryRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }

    public function index()
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $categories = $this->repo()->getPaginatedForOwner($companyId, $with);

        return $this->response()
                ->resource()
                ->including($with)
                ->withPaginated($categories, new CategoryTransformer);
    }

    
    public function store(CategoryRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->saveForOwner($request->all(), $companyId);

        return $this->response()->created();
    }
    
    public function update($id, CategoryRequest $request)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->updateForOwner($this->decode($id), $request->all(), $companyId);
        
        return $this->response()->updated();
    }

    public function destroy($id)
    {
         $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'delete-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $decodedId = $this->decode($id);
        
        $this->repo()->destroyForOwner($decodedId, $companyId);

        return $this->response()->deleted();
    }
}
