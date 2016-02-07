<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Company;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class ProductRepository extends EloquentRepository implements OwnerThroughableRepo
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
            
            $this->saveVariantsToProducts($data['variants'], $products);
              
        
        });
        
    }
    
    public function updateWithVariantsThroughOutlet($data, $companyId, $productId, $outletId)
    {
        
        \DB::transaction(function () use ($data, $companyId, $outletId, $productId)
        {
            $product = $this->updateForOwnerThrough(
                $productId, $data, $companyId, $outletId, 'outlets'
            );
                
            
            if ( isset($data['variants']) ) {
                
                $this->updateVariants($data['variants'], $product);
                
            }
        
        });
        
    }
    
    public function getTotalBestSellerForCompany($companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw('products.name, sum(order_variant.total) as total')
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereExists(function($query) use ($companyId)
                    {
                        $query->select(\DB::raw(1))
                            ->from('categories')
                            ->whereRaw('categories.id = products.category_id')
                            ->where('categories.company_id', '=', $companyId);
                    })
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('products.name')
                    ->orderBy('total', 'desc')
                    ->paginate($perPage);
    }
    
    public function getTotalBestAmountsForCompany($companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw(
                            "products.name ,"
                            . "sum( (variants.price - order_variant.nego) * order_variant.total ) as total"
                        )
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereExists(function($query) use ($companyId)
                    {
                        $query->select(\DB::raw(1))
                            ->from('categories')
                            ->whereRaw('categories.id = products.category_id')
                            ->where('categories.company_id', '=', $companyId);
                    })
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('products.name')
                    ->orderBy('total', 'desc')
                    ->paginate($perPage);
    }
    
    public function getTotalBestSellerForOutlet($outletId, $companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw('products.name, sum(order_variant.total) as total')
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereExists(function($query) use ($companyId, $outletId)
                    {
                        $query->select(\DB::raw(1))
                            ->from('outlets')
                            ->where('outlets.id', '=', $outletId)
                            ->whereRaw('outlets.id = products.outlet_id')
                            ->where('outlets.company_id', '=', $companyId);
                    })
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('products.id')
                    ->orderBy('total', 'desc')
                    ->paginate($perPage);
    }
    
    public function getTotalBestAmountsForOutlet($outletId, $companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw(
                            "products.name ,"
                            . "sum( (variants.price - order_variant.nego) * order_variant.total ) as total"
                        )
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereExists(function($query) use ($companyId, $outletId)
                    {
                        $query->select(\DB::raw(1))
                            ->from('outlets')
                            ->where('outlets.id', '=', $outletId)
                            ->whereRaw('outlets.id = products.outlet_id')
                            ->where('outlets.company_id', '=', $companyId);
                    })
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('products.id')
                    ->orderBy('total', 'desc')
                    ->paginate($perPage);
    }
    
    /**
     * 
     * @param array $variants
     * @param array $products
     * @return array
     */
    protected function saveVariantsToProducts($variants, $products)
    {
        $instances = [];
        
        foreach ($products as $product) {
            
            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }
            
        } 
        
        return $instances;
    }
    
    protected function updateVariants($variants)
    {
        $instances = [];
        //dd($variants);
        foreach ($variants as $variant) {
            $instances[] = Variant::findOrFail($variant['id'])
                                    ->update($variant);
        }
        
        return $instances;
    }

}
