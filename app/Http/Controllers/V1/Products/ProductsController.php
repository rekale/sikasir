<?php

namespace Sikasir\Http\Controllers\V1\Products;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Transformer\ProductBestTransformer;
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

    
    public function bestSeller($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $product = $this->repo()->getTotalBestSellerForCompany($companyId, $dateRange);
        
        return $this->response()
                ->resource()
                ->withPaginated($product, new ProductBestTransformer);
    }
    
    public function bestAmounts($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $product = $this->repo()->getTotalBestAmountsForCompany($companyId, $dateRange);
        
        return $this->response()
                ->resource()
                ->withPaginated($product, new ProductBestTransformer);
        
    }
    
    public function profit($dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
        
        $companyId = $currentUser->getCompanyId();
       
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $product = $this->repo()->getProfitForCompany($companyId, $dateRange);
        
        return $product;

    }
}
