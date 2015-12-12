<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Products\Product;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Products\Variant;
/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class ProductRepository extends Repository implements BelongsToOwnerRepo
{
    public function __construct(Product $product) 
    {
        parent::__construct($product);
    }

    
    public function saveWithVariants(array $data, array $variants)
    {
        $product = $this->save($data);
        
        $variantModels = [];
        
        foreach ($variants as $variant) {
            $variantModels[] = new Variant($variant);
        }
        
        $product->variants()->saveMany($variantModels);
        
    }
    
    public function saveForOwner(array $data, Owner $owner)
    {
        return false;
    }
    
    public function destroyForOwner($id, Owner $owner) 
    {
        $owner->products()
                ->findOrFail($id)
                ->delete();
        
    }

    public function findForOwner($id, Owner $owner) 
    {
        return $owner->products()->findOrFail($id);
    }

    public function getPaginatedForOwner(Owner $owner) 
    {
        return $owner->products()->paginate();
    }

    public function updateForOwner($id, array $data, Owner $owner) 
    {
        $product = $owner->products()->findOrFail($id);
        
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
        
    }

}
