<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
use Sikasir\V1\Repositories\Interfaces\ReportableRepo;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class ProductRepository extends EloquentRepository implements OwnerThroughableRepo, ReportableRepo
{
    use Traits\EloquentOwnerThroughable;
    
    public function __construct(Product $product) 
    {
        parent::__construct($product);
    }
    
    public function saveManyWithVariantsForCompany($data, $companyId)
    {
        
        \DB::transaction(function () use ($data, $companyId)
        {
            $products = [];
            
            //save the product to outlets
            foreach ($data['outlet_ids'] as $outletId) {
                
                $products[] = $this->saveForOwnerThrough(
                    $data, $companyId, $outletId, 'outlets'
                );
                
            }
            
            $this->saveVariants($data['variants'], $products);
              
        
        });
        
    }
    
    public function updateWithVariantsThroughOutlet($data, $companyId, $productId, $outletId)
    {
        
        \DB::transaction(function () use ($data, $companyId, $outletId, $productId)
        {
            $this->updateForOwnerThrough(
                $productId, $data, $companyId, $outletId, 'outlets'
            ); 
           
            if ( isset($data['variants']) ) {
                
                $product = $this->find($productId);
                
                $this->updateVariants($data['variants'], $product);
                
            }
        
        });
        
    }
    
    
    public function getBestSellerForCompany($companyId, $dateRange, $outletId = null, $perPage = 15)
    {
        return $this->queryForOwnerThrough($companyId, $outletId, 'outlets')
                    ->getTotalAndAmounts($dateRange)
                    ->orderByBestSeller()
                    ->paginate($perPage);
    }
    
    /**
     * 
     * @param array $variants
     * @param array $products
     * @return array
     */
    protected function saveVariants($variants, $products)
    {
        $instances = [];
        
        foreach ($products as $product) {
            
            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }
            
        } 
        
        return $instances;
    }
    
    protected function updateVariants($variants, $product)
    {
        $instances = [];
        //dd($variants);
        foreach ($variants as $variant) {
            
            
            if(! isset($variant['id'])) {
                $product->variants()->create($variant);
            }
            else {
                $instances[] = Variant::findOrFail($variant['id'])
                                        ->update($variant);
            }
        }
        
        
        return $instances;
    }

    public function getReportsForCompany($companyId, $dateRange, $outletId = null, $perPage = 15) {
         return $this->queryForOwnerThrough($companyId, $outletId, 'outlets')
                    ->getTotalAndAmounts($dateRange)
                    ->paginate($perPage);
    }

}
