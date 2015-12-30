<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Outlet;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;
use Sikasir\V1\Stocks\Stock;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutletTransformer extends TransformerAbstract
{
    use \Sikasir\V1\Traits\IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'employees',
        'cashiers',
        'stocks',
        'entries',
        'incomes',
        'outcomes',
        'customers',
        'variants',
    ];

    public function transform(Outlet $outlet)
    {
        return [
            'id' => $this->encode($outlet->id),
            'name' => $outlet->name,
            'business_field' => $outlet->businessfield->name,
            'address' => $outlet->address,
            'province' => $outlet->province,
            'city' => $outlet->city,
            'pos_code' => $outlet->pos_code,
            'phone1' => $outlet->phone1,
            'phone2' => $outlet->phone2,
            'icon' => $outlet->icon,
            'tax' => $outlet->tax->toArray(),

        ];
    }

    public function includeEmployees(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->employees());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();

        return $this->collection($collection, new EmployeeTransformer);
    }
    
    public function includeCashiers(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->cashiers());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();

        return $this->collection($collection, new CashierTransformer);
    }
    
    public function includeStocks(Outlet $outlet, ParamBag $params = null)
    {
       $stocks = Stock::with('variant')->where('outlet_id', $outlet->id);
       
       $query = $this->setBuilder($stocks);
       
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new StockTransformer);
    }
    
     public function includeEntries(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $outlet->entries;
        
        return $this->collection($collection, new EntryTransformer);
    }
    
    public function includeCustomers(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->customers());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new CustomerTransformer);
    }
    
    
    public function includeIncomes(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->incomes());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new IncomeTransformer);
    }
    
    
    public function includeOutcomes(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->outcomes());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new OutcomeTransformer);
    }
    
    public function includeVariants(Outlet $outlet, ParamBag $params = null)
    {
        $query = $this->setBuilder($outlet->variants());
        
        $collection = is_null($params) 
                        ? $query->result()
                        : $query->paramsLimit($params->get('limit'))
                            ->paramsOrder($params->get('order'))
                            ->result();
        
        return $this->collection($collection, new VariantTransformer);
    }

}
