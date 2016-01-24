<?php

namespace Sikasir\V1\Repositories\Interfaces;

interface OwnerThroughableRepo
{
    /**
     * 
     * @param integer $id
     * @param string $throughTableName
     * @param integer $ownerId
     * @param integer $throughId
     * @param integer $with
     * @return type
     */
    public function findForOwnerThrough($id, $throughTableName, $ownerId, $throughId, $with = []);
    
     /**
      * 
      * @param string $throughTableName
      * @param integer $ownerId
      * @param integer $throughId
      * @param array $with
      * @param integer $perPage
      * @return Paginator
      */
     public function getPaginatedForOwnerThrough($throughTableName, $ownerId, $throughId, $with = [], $perPage = 15);
    
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
    public function saveForOwnerThrough(array $data, $ownerId, $throughId, $throughTableName);
    
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
    public function updateForOwnerThrough($id, array $data, $ownerId, $throughId, $throughTableName);
    
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
    public function destroyForOwnerThrough($id, $ownerId, $throughId, $throughTableName);
    
    
}
