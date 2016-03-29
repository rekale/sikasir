<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Products\Category;
use \Sikasir\V1\Traits\IdObfuscater;
use League\Fractal\ParamBag;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class CategoryTransformer extends TransformerAbstract
{
    use IdObfuscater;
    
    protected $availableIncludes = [
        'products',
    ];

    public function transform(Category $category)
    {
        $data = [
            'id' => $this->encode($category->id),
            'name' => $category->name,
            'description' => $category->description,
        ];
        
        //if it's the report
        if (isset($category->total))
        {
            $data['total'] = (int) $category->total;
            $data['amounts'] = (int) $category->amounts;
        }
        
        return $data;
    }
    
    public function includeProducts(Category $category, ParamBag $params = null)
    {
        $collection = $category->products;
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    

}
