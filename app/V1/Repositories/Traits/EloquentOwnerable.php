<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories\Traits;

/**
 * Description of ObfuscaterId
 *
 * @author rekale
 */
trait EloquentOwnerable 
{
    
    public function queryForOwner($companyId)
    {
        return $this->model
                    ->where('company_id', '=', $companyId);
    }
    
    
     /**
     * 
     * @param integer $id
     * @param integer $companyId
     * @param integer $with
     * @return type
     */
    public function findForOwner($id, $companyId, $with = [])
    {
        return $this->queryForOwner($companyId)
                    ->with($with)
                    ->findOrFail($id);
    }
    
     /**
      * 
      * @param integer $companyId
      * @param array $with
      * @param integer $perPage
      * @return Paginator
      */
     public function getPaginatedForOwner($companyId, $with = [], $perPage = 15)
     {
         return $this->queryForOwner($companyId)
                    ->with($with)
                    ->paginate($perPage);
     }
    
    /**
    * save the current model to owner
    *
    * @param array $data
    * @param integer $companyId
    *
    * @return static
    */
    public function saveForOwner(array $data, $companyId)
    {
        $data['company_id'] = $companyId;
        
        return $this->model->create($data);
    }
    
    /**
    * update the current model to owner
    *
    * @param integer $id
    * @param array $data
    * @param integer $companyId
    *
    * @return void
    */
    public function updateForOwner($id, array $data, $companyId)
    {
        return $this->findForOwner($id, $companyId)
                    ->update($data);
    }
    
    /**
     * delete specific resource that owner belong
     * 
     * @param integer $id
     * @param integer $companyId
     * 
     * return boolean
     */
    public function destroyForOwner($id, $companyId)
    {
        return $this->findForOwner($id, $companyId)
                ->delete();
    }
    
}
