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
    
     /**
     * 
     * @param integer $id
     * @param integer $ownerId
     * @param integer $with
     * @return type
     */
    public function findForOwner($id, $ownerId, $with = [])
    {
        return $this->model
                    ->with($with)
                    ->where('owner_id', '=', $ownerId)
                    ->findOrFail($id);
    }
    
     /**
      * 
      * @param integer $ownerId
      * @param array $with
      * @param integer $perPage
      * @return Paginator
      */
     public function getPaginatedForOwner($ownerId, $with = [], $perPage = 15)
     {
         return $this->model
                    ->with($with)
                    ->where('owner_id', '=', $ownerId)
                    ->paginate($perPage);
     }
    
    /**
    * save the current model to owner
    *
    * @param array $data
    * @param integer $ownerId
    *
    * @return static
    */
    public function saveForOwner(array $data, $ownerId)
    {
        $data['owner_id'] = $ownerId;
        
        return $this->model->create($data);
    }
    
    /**
    * update the current model to owner
    *
    * @param integer $id
    * @param array $data
    * @param integer $ownerId
    *
    * @return void
    */
    public function updateForOwner($id, array $data, $ownerId)
    {
        return $this->findForOwner($id, $ownerId)
                    ->update($data);
    }
    
    /**
     * delete specific resource that owner belong
     * 
     * @param integer $id
     * @param integer $ownerId
     * 
     * return boolean
     */
    public function destroyForOwner($id, $ownerId)
    {
        return $this->findForOwner($id, $ownerId)
                ->delete();
    }
    
}
