<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class ProductRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;
    
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
     * @param Owner $owner
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
    
    public function getPaginatedForOwner($ownerId, $with = array(), $perPage = 15) {
        
        return Product::whereExists(function ($query) use($ownerId) {
                $query->select(\DB::raw(1))
                      ->from('categories')
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('categories.id = products.category_id');
                })
                ->paginate($perPage);
        
    }
    
    public function saveForOwner(array $data, $ownerId)
    {
        \DB::transaction(function() use ($data, $ownerId) {
            
            //check if this category is belong to current owner
            $category = Category::where('owner_id' , '=', $ownerId)
                                ->findOrFail($data['category_id']);

            $product = $category->products()->save(new Product($data));

            $variantModels = [];

            foreach ($data['variants'] as $variant) {
                $variantModels[] = new Variant($variant);
            }

            $variants = $product->variants()->saveMany($variantModels);
            
            //find product that related to current owner
            $outlets = Outlet::where('owner_id', '=', $ownerId)
                            ->findMany($data['outlet_ids']);
            
            //save product to these outlets
            foreach($outlets as $outlet) {
                $outlet->products()->save($product);
            }
            
            //save variant's product to outlet alias to stock
            $outlet->variants()->saveMany($variants);
            
        });
        
    }
    
    public function updateForOwner($id, array $data, $ownerId) 
    {
        \DB::transaction(function() use ($id, $data, $ownerId){
        
            $category = Category::where('owner_id', '=', $ownerId)
                                ->findOrFail($data['category_id']);

            $product = $category->products()->findOrFail($id);

            $product->update($data);

            $deletedExistVariantIds = [];
            $newVariants = [];

            foreach($data['variants'] as $variant) {

                if ( isset($variant['id']) ) {

                    if ($variant['delete']) {
                        $deletedExistVariantIds[] = $variant['id'];
                    }
                    else {
                        $product->findOrFail($variant['id'])
                            ->update($variant);
                    }

                }
                else {
                    $newVariants[] = new Variant($variant);
                }

            }

            Variant::destroy($deletedExistVariantIds); 

            $product->variants()->saveMany($newVariants);
        
            
        });
        
    }

}
