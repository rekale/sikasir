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

    /**
     * get customers for specific outlet
     *
     * @param integer $outletId
     * @param boolean $paginated
     * @param integer $perPage
     *
     * @return Collection | Paginator
     */
    public function getCustomers($outletId, $paginated = true, $perPage = 15)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->customers()
                        ->paginate($perPage)
                   : $this->findWith($outletId,['customers'])
                        ->customers ;
    }

    /**
     * save oustomers for specific outlet
     *
     * @param integer $outletId
     * @param array $data
     * @return boolean
     */
    public function saveCustomers($outletId, array $data)
    {
        return $this->find($outletId)->customers()->save($data);
    }


    /**
     * get employees that working in speicific outlet
     *
     * @param integer $outletId
     * @param boolean $paginated
     * @param integer $perPage
     *
     * @return Collection | Paginator
     */
    public function getEmployees($outletId, $paginated = true, $perPage = 10)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->employees()
                        ->paginate($perPage)
                   : $this->findWith($outletId, ['employees'])
                        ->employees;
    }
    
    /**
     * get outlet's stock
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getStocksPaginated($outletId, $ownerId, $with =[], $perPage = 15)
    {
        return Stock::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = stocks.outlet_id');
                })
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's stock entries
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getEntriesPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
         return Entry::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = entries.outlet_id');
                })
                ->with($with)
                ->paginate($perPage);
    }
    /**
     * get outlet's stock outs
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOutsPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
       return Out::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = outs.outlet_id');
                })
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's stock opnames
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOpnamesPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Stocks\Opname::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = opnames.outlet_id');
                })
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getOrdersPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
       return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('void', '=', false)
                ->with($with)
                ->paginate($perPage);
    }
    
    
    /**
     * get outlet's voided orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getOrdersVoidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('void', '=', true)
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's paid only orders
     *
     * @param integer $outletId
     * @param integer $ownerId
     *
     * @return Collection | Paginator
     */
    public function getOrdersPaidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('paid', '=', true)
                ->with($with)
                ->paginate($perPage);
    }
    
    /**
     * get outlet's unpaid only orders
     *
     * @param integer $outletId
     * @param integer ownerId
     *
     * @return Collection | Paginator
     */
    public function getOrdersUnpaidPaginated($outletId, $ownerId, $with =[],$perPage = 15)
    {
        return \Sikasir\V1\Orders\Order::whereExists(function ($query) use($ownerId, $outletId) {
                $query->select(\DB::raw(1))
                      ->from('outlets')
                      ->where('id', '=', $outletId)
                      ->where('owner_id', '=', $ownerId)
                      ->whereRaw('outlets.id = orders.outlet_id');
                })
                ->where('paid', '=', false)
                ->with($with)
                ->paginate($perPage);
    }


}
