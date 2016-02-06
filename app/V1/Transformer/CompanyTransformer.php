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
class CompanyTransformer extends TransformerAbstract
{
   use \Sikasir\V1\Traits\IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'outlets',
        'users',
        'taxes',
        'discounts',
        'payments',
        'categories',
    ]; 
    
    public function transform(Company $company)
    {
        return [
            'id' => $this->encode($company->id),
            'name' => $company->name, 
            'phone' => $company->phone, 
            'address' => $company->address, 
            'icon' => $company->icon, 
            'active' => (boolean) $company->active,
        ];
    }
    
    public function includeOutlets(Company $company, ParamBag $params = null)
    {
        
       $collection = $company->outlets;
        
        return $this->collection($collection, new OutletTransformer);
    }
    
    public function includeUsers(Company $company, ParamBag $params = null)
    {
        $collection = $company->users;
        
        return $this->collection($collection, new UserTransformer);
    }
   
    public function includeCategories(Company $company, ParamBag $params = null)
    {
         $collection = $company->categories;
        
        return $this->collection($collection, new CategoryTransformer);
    }
    
    public function includeTaxes(Company $company, ParamBag $params = null)
    {
        $collection = $company->taxes;
        
        return $this->collection($collection, new TaxTransformer);
    }
    
    public function includeDiscounts(Company $company, ParamBag $params = null)
    {   
        $collection = $company->discounts;
        
        return $this->collection($collection, new TaxTransformer);
    }
    
    public function includePayments(Company $company, ParamBag $params = null)
    {   
        $collection = $company->payments;
        
        return $this->collection($collection, new PaymentTransformer);
    }
    
}
