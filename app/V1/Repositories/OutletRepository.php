<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Products\Product;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OutletRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;

    public function __construct(Outlet $outlet) {
        parent::__construct($outlet);
    }
    
    /**
     * get the best outlet from specific company
     * the best outlet is determined by how many products have sold
     * more products sold, the better its rank
     * 
     * @param integer $companyId
     * @param array $dateRange
     * @param integer $perPage
     * @return Collection
     */
    public function getTheBestForCompany($companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw(
                            "outlets.name, "
                            . "sum( order_variant.total ) as total"
                        )
                    )
                    ->join('orders', 'outlets.id', '=', 'orders.outlet_id')
                    ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                    ->where('outlets.company_id', '=', $companyId)
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->groupBy('outlets.id')
                    ->orderBy('total', 'desc')
                    ->paginate($perPage);
    }
    
    /**
     * 
     * get profit from all outlet
     * or from specific outlet if outletId is not null
     * 
     * @param integer $companyId
     * @param array $dateRange
     * @param integer $outletId
     * @return type
     */
    public function getProfitForCompany($companyId, $dateRange = [], $outletId = null)
    {
        $query = $this->model
                    ->select(
                        \DB::raw(
                            "sum( (variants.price - order_variant.nego - variants.price_init ) * order_variant.total ) as total"
                        )
                    )
                    ->join('orders', 'outlets.id', '=', 'orders.outlet_id')
                    ->join('order_variant', 'orders.id', '=', 'order_variant.order_id')
                    ->join('variants', 'order_variant.variant_id', '=', 'variants.id')
                    ->where('outlets.company_id', '=', $companyId)
                    ->whereBetween('order_variant.created_at', $dateRange);
        
        if(! is_null($outletId))
        {
            $query->where('outlets.id', '=', $outletId);
        }
        
        return $query->get();
        
    }
    
    
    public function getProfitForOutlet($outletId, $companyId, $dateRange = [], $perPage = 15)
    {
        return $this->model
                    ->select(
                        \DB::raw(
                            "sum( (variants.price - order_variant.nego - variants.price_init) * order_variant.total ) as total"
                        )
                    )
                    ->join('variants', 'variants.product_id', '=', 'products.id')
                    ->join('order_variant', 'order_variant.variant_id', '=', 'variants.id')
                    ->whereExists(function($query) use ($companyId, $outletId)
                    {
                        $query->select(\DB::raw(1))
                            ->from('outlets')
                            ->where('outlets.id', '=', $outletId)
                            ->whereRaw('outlets.id = products.outlet_id')
                            ->where('outlets.company_id', '=', $companyId);
                    })
                    ->whereBetween('order_variant.created_at', $dateRange)
                    ->get();
    }
   
    /**
     * get incomes for specific outlet
     *
     * @param integer $outletId
     * @param boolean $paginated
     * @param integer $perPage
     *
     * @return Collection | Paginator
     */
    public function getIncomes($outletId, $paginated = true, $perPage = 10)
    {
        return $paginated ? $this->find($outletId)->incomes()->paginate($perPage) :
            $this->findWith($outletId, ['incomes'])->incomes ;
    }

    /**
     * save income for specifi outlet
     *
     * @param integer $outletId
     * @param array $data
     * @return boolean
     */
    public function saveIncome($outletId, array $data)
    {
        return $this->find($outletId)->incomes()->save($data);
    }

    /**
     * delete incomes for specific outlet
     *
     * @param integer $outletId
     * @param integer|array $data
     * @return boolean
     */
    public function destroyIncome($outletId, $data)
    {
        return $this->find($outletId)->incomes()->destroy($data);
    }

    /**
     * get outcomes for specific outlet
     *
     * @param integer $outletId
     * @param boolean $paginated
     * @param integer $perPage
     *
     * @return Collection | Paginator
     */
    public function getOutcomes($outletId, $paginated = true, $perPage = 15)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->outcomes()
                        ->paginate($perPage)
                   : $this->findWith($outletId, ['outcomes'])
                        ->outcomes ;
    }

    /**
     * save outcome for specifi outlet
     *
     * @param integer $outletId
     * @param array $data
     * @return boolean
     */
    public function saveOutcome($outletId, array $data)
    {
        return $this->find($outletId)->outcomes()->save($data);
    }

    /**
     * delete outcomes for specific outlet
     *
     * @param integer $outletId
     * @param integer|array $data
     * @return boolean
     */
    public function destroyOutcome($outletId, $data)
    {
        return $this->find($outletId)->outcomes()->destroy($data);
    }

}
