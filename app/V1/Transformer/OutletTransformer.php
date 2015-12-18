<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Transformer\StockDetailTransformer;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;
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
        'stocks',
        'stock_entries',
        'stock_outs',
        'incomes',
        'outcomes',
        'customers',
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
        
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
        
        $employees = $outlet->employees()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();

        return $this->collection($employees, new EmployeeTransformer);
    }
    
    public function includeStocks(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $details = $outlet->stockDetails()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($details, new StockDetailTransformer);
    }
    
    public function includeStockEntries(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $details = $outlet->stockEntries()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($details, new StockEntryTransformer);
    }
    
    public function includeStockOuts(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $details = $outlet->stockOuts()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($details, new StockOutTransformer);
    }
    
    public function includeCustomers(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $customers = $outlet->customers()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($customers, new CustomerTransformer);
    }
    
    
    public function includeIncomes(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $outlet->incomes()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new IncomeTransformer);
    }
    
    
    public function includeOutcomes(Outlet $outlet, ParamBag $params = null)
    {
        $this->filterLimitParams($params->get('limit'));
        $this->filterOrderParams($params->get('order'));
       
        $collection = $outlet->outcomes()
                            ->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
        
        return $this->collection($collection, new OutcomeTransformer);
    }
    

}
