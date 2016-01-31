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

}
