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
trait EloquentOwnerThroughable
{
    
    /**
     * 
     * @param integer $id
     * @param integer $ownerId
     * @param integer $throughId
     * @param string $throughTableName
     * @param integer $with
     * @return type
     */
    public function findForOwnerThrough($id, $ownerId, $throughId, $throughTableName , $with = [])
    {
        
    }
  
    /**
    * save the current model to owner
    *
    * @param array $data
    * @param integer $ownerId
     * @param integer $throughId
     * @param string $throughTableName
    *
    * @return static
    */
    public function saveForOwnerThrough(array $data, $ownerId, $throughId, $throughTableName)
    {
        
    }
    
    /**
    * update the current model to owner
    *
    * @param integer $id
    * @param array $data
    * @param integer $ownerId
     * @param integer $throughId
     * @param string $throughTableName
    *
    * @return void
    */
    public function updateForOwnerThrough($id, array $data, $ownerId, $throughId, $throughTableName)
    {
        
    }
    
    /**
     * delete specific resource that owner belong
     * 
     * @param integer $id
     * @param integer $ownerId
     * @param integer $throughId
     * @param string $throughTableName
     * 
     * return boolean
     */
    public function destroyForOwnerThrough($id, $ownerId, $throughId, $throughTableName)
    {
        
    }
    
    
     /**
      * 
      * @param integer $ownerId
      * @param integer $throughId
      * @param string $throughTableName
      * @param array $with
      * @param integer $perPage
      * 
      * @return Paginator
      */
     public function getPaginatedForOwnerThrough($ownerId, $throughId, $throughTableName, $with = [], $perPage = 15)
     {
         return $this->model->whereExists(
                            function ($query) use($ownerId, $throughId, $throughTableName) {
                                
                                $modelForeignId = $this->model->getTable() . '.' . str_singular($throughTableName) . '_id';
                                
                                $constraint = $throughTableName . '.id' . ' = ' . $modelForeignId;
                                
                                $query->select(\DB::raw(1))
                                      ->from($throughTableName)
                                      ->where('id', '=', $throughId)
                                      ->where('owner_id', '=', $ownerId)
                                      ->whereRaw($constraint);
                            })
                            ->with($with)
                            ->paginate($perPage);
     }
    
}
