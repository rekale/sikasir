<?php

namespace Sikasir\V1\Transformer;

use \League\Fractal\TransformerAbstract;
use Sikasir\V1\Outlets\Outlet;
use League\Fractal\ParamBag;
use \Sikasir\V1\Traits\ParamTransformer;
use Sikasir\V1\Stocks\StockDetail;
use \Sikasir\V1\Traits\IdObfuscater;
use Sikasir\V1\Outlets\Printer;

/**
 * Description of AppTransformer
 *
 * @author rekale
 */
class OutletTransformer extends TransformerAbstract
{
    use IdObfuscater, ParamTransformer;
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'employees',
        'cashiers',
        'incomes',
        'outcomes',
        'customers',
        'printers',
    ];
    
    protected $defaultIncludes = [
        'tax',
        'business_field',
    ];

    public function transform(Outlet $outlet)
    {
        return [
            'id' => $this->encode($outlet->id),
            'name' => $outlet->name,
            'address' => $outlet->address,
            'province' => $outlet->province,
            'city' => $outlet->city,
            'pos_code' => $outlet->pos_code,
            'phone1' => $outlet->phone1,
            'phone2' => $outlet->phone2,
            'icon' => $outlet->icon,

        ];
    }
    
    public function includeTax(Outlet $outlet)
    {
        $collection = $outlet->tax;
        
        return $this->item($collection, new TaxTransformer);
    }
    
    public function includeBusinessField(Outlet $outlet)
    {
        $collection = $outlet->businessField;
        
        return $this->item($collection, new BusinessFieldTransformer);
    }
    
    public function includeEmployees(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->employees(), $params['per_page'][0], $params['current_page'][0]
        )->result();

        return $this->collection($collection, new EmployeeTransformer);
    }
    
    public function includeCashiers(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->cashiers(), $params['per_page'][0], $params['current_page'][0]
        )->result();

        return $this->collection($collection, new CashierTransformer);
    }
     
    public function includeEntries(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->entries(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new InventoryTransformer);
    }
    
     public function includeOuts(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->outs(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new OutTransformer);
    }
    
    public function includeOpnames(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->opnames(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new OpnameTransformer);
    }
    
    public function includeCustomers(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->customers(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new CustomerTransformer);
    }
    
    
    public function includeIncomes(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->incomes(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new IncomeTransformer);
    }
    
    
    public function includeOutcomes(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->outcomes(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new OutcomeTransformer);
    }
    
    public function includeOrders(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->orders(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new OrderTransformer);
    }
    
    public function includePrinters(Outlet $outlet, ParamBag $params = null)
    {
        $collection = $this->setData(
            $outlet->printers(), $params['per_page'][0], $params['current_page'][0]
        )->result();
        
        return $this->collection($collection, new PrinterTransformer);
    }

}
