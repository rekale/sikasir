<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Company;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Products\Category;
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
    
    public function getCategories($ownerId)
    {
        return Category::where('owner_id', '=', $ownerId)->paginate();
    }
    
    /**
     * create new categories
     * 
     * @param Company $owner
     * @param string $category
     */
    public function saveCategory($ownerId, $category)
    {
        Category::create([
            'owner_id' => $ownerId,
            'name' => $category,
        ]);
    }
    
    /**
     * 
     * @param integer $ownerId
     * @param integer $id
     * @param string $name
     */
    public function updateCategory($ownerId, $id, $name)
    {
        Category::where('owner_id', '=', $ownerId)
                ->findOrFail($id)
                ->update( 
                    ['name' => $name] 
                );
    }
    
    /**
     * delete category
     * 
     * @param integer $ownerId
     * @param integer $categories
     */
    public function destroyCategories($ownerId, $id)
    {
        Category::where('owner_id', '=', $ownerId)
                ->findOrFail($id)   
                ->delete();
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
   
    /**
     * 
     * save many products
     * 
     * @param array $dataInput
     * @param integer $categoryId
     * @return array
     */
    protected function saveVariants($dataInput, $categoryId, $productId)
    {
        $instances = [];
        
        foreach ($dataInput as $data) {
            $data['category_id'] = $categoryId;
            $data['product_id'] = $productId;
            $instances[] = $this->save($data);
        }
        
        return $instances;
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
