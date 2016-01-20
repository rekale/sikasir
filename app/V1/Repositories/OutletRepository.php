<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\Stock;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OutletRepository extends Repository
{

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
    public function getOutcomes($outletId, $paginated = true, $perPage = null)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->outcomes()
                        ->paginate($this->perPage($perPage))
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
    public function getCustomers($outletId, $paginated = true, $perPage = null)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->customers()
                        ->paginate($this->perPage($perPage))
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
     * get products for specific outlet
     *
     * @param integer $outletId
     * @param boolean $paginated
     * @param integer $perPage
     *
     * @return Collection | Paginator
     */
    public function getProducts($outletId, $paginated = true, $perPage = null)
    {
           return $paginated 
                   ? $this->find($outletId)
                        ->products()
                        ->paginate($this->perPage($perPage)) 
                   : $this->findWith($outletId, ['products'])
                        ->products ;
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
    public function getOpnamesPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['opnames'])
                ->opnames()
                ->with($with)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's orders
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOrdersPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
       return $this->findForOwner($outletId, $owner, ['orders'])
                ->orders()
                ->with($with)
                ->whereVoid(false)
                ->paginate($this->perPage($perPage));
    }
    
    
    /**
     * get outlet's voided orders
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOrdersVoidPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['orders'])
                ->orders()
                ->with($with)
                ->whereVoid(true)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's paid only orders
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOrdersPaidPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['orders'])
                ->orders()
                ->with($with)
                ->wherePaid(true)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's unpaid only orders
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOrdersUnpaidPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['orders'])
                ->orders()
                ->with($with)
                ->wherePaid(false)
                ->paginate($this->perPage($perPage));
    }


}
