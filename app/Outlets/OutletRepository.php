<?php

namespace Sikasir\Outlets;

use Sikasir\Intefaces\Repository;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OutletRepository extends Repository
{
    protected function __construct(Outlet $outlet) {
        $this->model = $outlet;
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
        return $paginated ? $this->find($outletId)->incomes 
                : $this->find($outletId)->incomes()->paginate($perPage);
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
        if (is_array($data)) {
            foreach ($data as $id => $value) {   
                $data[$id] = $this->decode($value);                
            }
        }
        else {
            $data = $this->decode($data);
        }
        
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
        return $paginated ? $this->find($outletId)->outcomes 
                : $this->find($outletId)->incomes()->paginate($perPage);
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
        if (is_array($data)) {
            foreach ($data as $id => $value) {   
                $data[$id] = $this->decode($value);                
            }
        }
        else {
            $data = $this->decode($data);
        }
        
        return $this->find($outletId)->outcomes()->destroy($data);   
    }
}
