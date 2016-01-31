<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\User\Company;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OwnerTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'outlets',
        'employees',
        'cashiers',
        'taxes',
        'discounts',
        'payments',
        'categories',
        'products',
    ]; 
    
    public function transform(Company $owner)
    {
        return [
            'id' => $this->encode($owner->user->id),
            'email' => $owner->user->email,
            'name' => $owner->name, 
            'business_name' => $owner->business_name, 
            'phone' => $owner->phone, 
            'address' => $owner->address, 
            'icon' => $owner->icon, 
            'active' => (boolean) $owner->active,
        ];
    }
    
    public function includeOutlets(Company $owner, ParamBag $params = null)
    {
        
       $query = $this->setBuilder($owner->outlets());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsPaginate($params['per_page'][0], $params['current_page'][0])
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new OutletTransformer);
    }
    
    public function includeEmployees(Company $owner, ParamBag $params = null)
    {
        $query = $this->setBuilder($owner->employees());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsPaginate($params['per_page'][0], $params['current_page'][0])
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new EmployeeTransformer);
    }
    
    public function includeCategories(Company $owner, ParamBag $params = null)
    {
         $collection = $this->setData(
            $owner->categories(), $params['perPage'][0], $params['currentPage'][0]
        )->result();
        
        return $this->collection($collection, new CategoryTransformer);
    }
    
    public function includeProducts(Company $owner, ParamBag $params = null)
    {
        $query = $this->setBuilder($owner->products());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsPaginate($params['per_page'][0], $params['current_page'][0])
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new ProductTransformer);
    }
    
    public function includeTaxes(Company $owner, ParamBag $params = null)
    {
        $query = $this->setBuilder($owner->taxes());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsPaginate($params['per_page'][0], $params['current_page'][0])
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new TaxTransformer);
    }
    
    public function includeDiscounts(Company $owner, ParamBag $params = null)
    {   
        $collection = $this->setData(
            $owner->discounts(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new TaxTransformer);
    }
    
    public function includePayments(Company $owner, ParamBag $params = null)
    {   
        $collection = $this->setData(
            $owner->payments(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new PaymentTransformer);
    }
    
}
