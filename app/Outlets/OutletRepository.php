<?php

namespace Sikasir\Outlets;

use Sikasir\Interfaces\Repository;
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
            $this->find($outletId)->incomes ;
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
           return $paginated ? $this->find($outletId)->outcomes()->paginate($perPage) : 
            $this->find($outletId)->outcomes ;
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
            $this->find($outletId)->incomes ;
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
     * delete customers for specific outlet
     * 
     * @param integer $outletId
     * @param integer|array $data
     * @return boolean
     */
    public function destroyCustomers($outletId, $data)
    {
        if (is_array($data)) {
            foreach ($data as $id => $value) {   
                $data[$id] = $this->decode($value);                
            }
        }
        else {
            $data = $this->decode($data);
        }
        
        return $this->find($outletId)->customers()->destroy($data);   
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
            $this->find($outletId)->products ;
    }
    
    
    /**
     * delete customers for specific outlet
     * 
     * @param integer $outletId
     * @param integer|array $data
     * @return boolean
     */
    public function destroyProducts($outletId, $data)
    {
        if (is_array($data)) {
            foreach ($data as $id => $value) {   
                $data[$id] = $this->decode($value);                
            }
        }
        else {
            $data = $this->decode($data);
        }
        
        return $this->find($outletId)->customers()->destroy($data);   
    }
}
