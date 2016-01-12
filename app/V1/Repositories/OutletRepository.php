<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOwnerRepo;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\StockTransfer;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OutletRepository extends Repository implements BelongsToOwnerRepo
{

    public function __construct(Outlet $outlet) {
        parent::__construct($outlet);
    }
    
    public function saveForOwner(array $data, Owner $owner)
    {
        $owner->outlets()->save(new Outlet($data));
    }
    
    public function destroyForOwner($id, Owner $owner) {
        $owner->outlets()->findOrFail($id);
        
        $this->destroy($id);
    }

    /**
     * 
     * @param integer $id
     * @param Owner $owner
     * @param  $with
     * @return type
     */
    public function findForOwner($id, Owner $owner, $with = []) 
    { 
        return $owner->outlets()->with($with)->findOrFail($id);
    }

    public function getPaginatedForOwner(Owner $owner, $with = []) 
    { 
        return $owner->outlets()->with($with)->paginate();
    }

    public function updateForOwner($id, array $data, Owner $owner) 
    {
        $owner->outlets()->findOrFail($id)->update($data);
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
    public function getStocksPaginated($outletId, Owner $owner, $with =[], $perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['stocks'])
                ->stocks()
                ->with($with)
                ->paginate($this->perPage($perPage));
    }
    
    /**
     * get outlet's stock entries
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getEntriesPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['entries'])
                ->entries()
                ->with($with)
                ->paginate($this->perPage($perPage));
    }
    /**
     * get outlet's stock outs
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getOutsPaginated($outletId, Owner $owner, $with =[],$perPage = null)
    {
        return $this->findForOwner($outletId, $owner, ['outs'])
                ->outs()
                ->with($with)
                ->paginate($this->perPage($perPage));
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
