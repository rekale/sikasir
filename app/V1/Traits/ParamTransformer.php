<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Traits;

use Illuminate\Database\Query\Builder;

/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait ParamTransformer
{
    
    private $limit = 15;
    private $offset = 0;
    private $orderCol = 'created_at';
    private $orderBy = 'asc';
    /**
     *
     * @var \Illuminate\Database\Query\Builder
     */
    private $query = null;
    
    /**
     * set the paginate parameter
     * 
     * @param integer $perPage
     * @param integer $currentPage
     * @return $
     */
    public function paramsPaginate($perPage, $currentPage)
    {
        if (isset($perPage)) {
            $this->limit = $perPage;
        }
        
        if(isset($currentPage)) {
            $this->offset = ($this->limit * $currentPage) - $this->limit;
        }
        
        return $this;
    }
    
    /**
     * set the query builder
     * 
     * @param Builder $query
     * @return $this
     */
    public function setBuilder($query)
    {
        $this->query = $query;
        
        return $this;
    }
    
    /**
     * get the result
     * 
     * @return array|static[]
     */
    public function result()
    {
        if(is_null($this->query)) {
            throw new \Exception('query is not set');
        }
        return $this->query->take($this->limit)
                            ->skip($this->offset)
                            ->orderBy($this->orderCol, $this->orderBy)
                            ->get();
    }
    
    /**
     * 
     * 
     * @param Builder $query
     * @param integer $perPage
     * @param integer $currentPage
     * @return $this
     */
    public function setData($query, $perPage = null, $currentPage = null)
    {
        $this->setBuilder($query)
            ->paramsPaginate($perPage, $currentPage);
        
        return $this;
    }
    
    /**
     * set order
     * 
     * @param string $orderCol
     * @param string $orderBy
     * @return $this
     */
    public function orderBy($orderCol, $orderBy)
    {
         if (isset($orderCol)) {
            $this->orderCol = $orderCol;
        }
        
        if(isset($orderBy)) {
            $this->orderBy = $orderBy;
        }
        
        return $this;
    }
    
   
}
