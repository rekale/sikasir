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
    
    public function store(ProductRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'create-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $dataInput = $request->all();
        
        $dataInput['category_id'] = $this->decode($dataInput['category_id']);
        $dataInput['outlet_ids'] = $this->decode($dataInput['outlet_ids']);
        
        $this->repo()->saveManyWithVariantsForCompany($dataInput, $companyId);
        
        return $this->response()->created();
    }

    
    public function best($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
       
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);
        
        $with = $this->filterIncludeParams($include);
        
        $product = $this->repo()->getTheBestProducts($dateRange);

        return $this->response()
                ->resource()
                ->including($with)
                ->withItem($product, new ProductTransformer);
    }
}
