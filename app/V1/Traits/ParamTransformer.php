<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Traits;

/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait ParamTransformer
{
    
    protected $limit = 15;
    protected $offset = 1;
    protected $orderCol = 'created_at';
    protected $orderBy = 'asc';
    
    public function filterLimitParams($params)
    {
        $this->limit = isset($params[0]) ? $params[0] : 15;
        $this->offset = isset($params[1]) ? $params[1] : 1;
    }
    
    
    public function filterOrderParams()
    {
        $this->orderCol = isset($params[0]) ? $params[0] : 'created_at';
        $this->orderBy = isset($params[1]) ? $params[1] : 'asc';
    }
}
