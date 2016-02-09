<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Products\Category;
use \Sikasir\V1\Traits\IdObfuscater;
use \Sikasir\V1\Traits\ParamTransformer;
use League\Fractal\ParamBag;
/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class CategoryTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    
    protected $availableIncludes = [
        'products',
    ];

    public function transform(Category $category)
    {
        return [
            'id' => $this->encode($category->id),
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
    
    public function includeProducts(Category $category, ParamBag $params = null)
    {
        $collection = $this->setData(
            $category->products(), $params['perPage'][0], $params['currentPage'][0]
        )->result();
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    

}
