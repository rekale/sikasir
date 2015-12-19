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
    private $offset = 1;
    private $orderCol = 'created_at';
    private $orderBy = 'asc';
    /**
     *
     * @var \Illuminate\Database\Query\Builder
     */
    private $query = null;
    
    /**
     * set the limit parameter
     * 
     * @param array $params
     * @return $this
     */
    public function paramsLimit($params)
    {
        $this->limit = isset($params[0]) ? $params[0] : 15;
        $this->offset = isset($params[1]) ? $params[1] : 1;
        
        return $this;
    }
    
    /**
     * set the order parameter
     * 
     * @param array $params
     * @return $this
     */
    public function paramsOrder($params)
    {
        $this->orderCol = isset($params[0]) ? $params[0] : 'created_at';
        $this->orderBy = isset($params[1]) ? $params[1] : 'asc';
        
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
                            ->orderBy($this->orderCol, $this->orderCol)
                            ->get();
    }
    
   
}
