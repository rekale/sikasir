<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOwnerRepo;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;

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

    public function findForOwner($id, Owner $owner) 
    {
        return $owner->outlets()->findOrFail($id);
    }

    public function getPaginatedForOwner(Owner $owner) 
    {
        return $owner->outlets()->paginate();
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
    public function getOutcomes($outletId, $paginated = true, $perPage = 10)
    {
           return $paginated ? $this->find($outletId)->outcomes()->paginate($perPage) :
            $this->findWith($outletId, ['outcomes'])->outcomes ;
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
    public function getCustomers($outletId, $paginated = true, $perPage = 10)
    {
           return $paginated ? $this->find($outletId)->customers()->paginate($perPage) :
            $this->findWith($outletId,['customers'])->customers ;
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
    public function getProducts($outletId, $paginated = true, $perPage = 10)
    {
           return $paginated ? $this->find($outletId)->products()->paginate($perPage) :
            $this->findWith($outletId, ['products'])->products ;
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
           return $paginated ? $this->find($outletId)->employees()->paginate($perPage) :
            $this->findWith($outletId, ['employees'])->employees;
    }
    
   /**
     * get outlet's stock
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getStocksPaginated($outletId, Owner $owner)
    {
        return $this->findForOwner($outletId, $owner)
                ->stockDetails()
                ->paginate();
    }
    
    /**
     * get outlet's stock entry history
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getStockEntriesPaginated($outletId, Owner $owner)
    {
        return $this->findForOwner($outletId, $owner)
                ->stockEntries() 
                ->paginate();
    }
    
    /**
     * get outlet's stock out history
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getStockOutsPaginated($outletId, Owner $owner)
    {
        return $this->findForOwner($outletId, $owner)
                ->stockOuts() 
                ->paginate();
    }
    
     /**
     * get outlet's stock transfer history
     *
     * @param integer $outletId
     * @param \Sikasir\V1\User\Owner
     *
     * @return Collection | Paginator
     */
    public function getStockTransfersPaginated($outletId, Owner $owner)
    {
        return $this->findForOwner($outletId, $owner)
                ->stockTransfers() 
                ->paginate();
    }
}
