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
        $collection = $this->setData(
            $category->products(), $params['perPage'][0], $params['currentPage'][0]
        )->result();
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    

}
