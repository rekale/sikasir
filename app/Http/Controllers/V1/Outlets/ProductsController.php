<?php

namespace Sikasir\Http\Controllers\V1\Outlets;

use Sikasir\Http\Controllers\ApiController;
use Sikasir\V1\Transformer\ProductBestTotalSalesTransformer;
use Sikasir\V1\Repositories\ProductRepository;
use Sikasir\V1\Traits\ApiRespond;
use Tymon\JWTAuth\JWTAuth;
use Sikasir\Http\Requests\ProductRequest;
use Sikasir\V1\Transformer\ProductTransformer;

class ProductsController extends ApiController
{
   protected $repo;
    
    public function __construct(ApiRespond $respond, ProductRepository $repo, JWTAuth $auth) {

        parent::__construct($respond, $auth, $repo);

    }
    
    /**
     * 
     * @param string $outletId
     */
   public function index($outletId)
   {    
        $currentUser =  $this->currentUser();

        $this->authorizing($currentUser, 'read-product');

        $ownerId = $currentUser->getCompanyId();

        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $decodedId = $this->decode($outletId);

        $products = $this->repo()
                        ->getPaginatedForOwnerThrough(
                            'outlets', $ownerId, $decodedId, $with
                        );
        
       return $this->response()
               ->resource()
               ->including($include)
               ->withPaginated($products, new ProductTransformer);
       
   }
   
   public function show($outletId, $productId)
   {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'read-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $decodedOutletId = $this->decode($outletId);
        $decodedProductId = $this->decode($productId);
        
        $include = filter_input(INPUT_GET, 'include', FILTER_SANITIZE_STRING);

        $with = $this->filterIncludeParams($include);
        
        $collection = $this->repo()->findForOwnerThrough(
            $decodedProductId, $companyId, $decodedOutletId, 'outlets', $with
        );
        
        return $this->response()
               ->resource()
               ->including($with)
               ->withItem($collection, new ProductTransformer);
        
   }
   
   public function update($outletId, $productId, ProductRequest $request)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $decodedOutletId = $this->decode($outletId);
        $decodedProductId = $this->decode($productId);
        
        $dataInput = $request->all();
        
        $dataInput['category_id'] = $this->decode($dataInput['category_id']);
        
        foreach ($dataInput['variants'] as &$variant) {
            
            if ( isset($variant['id']) ) {
                $variant['id'] = $this->decode($variant['id']);
            }
            
        }
        
        $this->repo()->updateWithVariantsThroughOutlet(
            $dataInput, $companyId, $decodedProductId, $decodedOutletId
        );

        return $this->response()->updated();
    }
    
    
    public function destroy($outletId, $productId)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $this->repo()->destroyForOwnerThrough(
            $this->decode($productId), $companyId, $this->decode($outletId), 'outlets'
        );
        
        return $this->response()->deleted();
    }
    
    public function best($outletId, $dateRange)
    {
        $currentUser =  $this->currentUser();
        
        $this->authorizing($currentUser, 'update-product');
       
        $companyId = $currentUser->getCompanyId();
        
        $dateRange = explode(',' , str_replace(' ', '', $dateRange));
        
        $products = $this->repo()->getTotalBestSalesForOutlet(
            $this->decode($outletId), $companyId, $dateRange
        );
        
        return $this->response()
               ->resource()
               ->withPaginated($products, new ProductBestTotalSalesTransformer);
    }
    

}
