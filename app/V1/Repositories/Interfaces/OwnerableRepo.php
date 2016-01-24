<?php

namespace Sikasir\V1\Repositories\Interfaces;

interface OwnerableRepo
{
    /**
     * 
     * @param integer $id
     * @param integer $ownerId
     * @param integer $with
     * @return type
     */
    public function findForOwner($id, $ownerId, $with = []);
    
     /**
      * 
      * @param integer $ownerId
      * @param array $with
      * @param integer $perPage
      * @return Paginator
      */
     public function getPaginatedForOwner($ownerId, $with = [], $perPage = 15);
    
    /**
    * save the current model to owner
    *
    * @param array $data
    * @param integer $ownerId
    *
    * @return static
    */
    public function saveForOwner(array $data, $ownerId);
    
    /**
    * update the current model to owner
    *
    * @param integer $id
    * @param array $data
    * @param integer $ownerId
    *
    * @return void
    */
    public function updateForOwner($id, array $data, $ownerId);
    
    /**
     * delete specific resource that owner belong
     * 
     * @param integer $id
     * @param integer $ownerId
     * 
     * return boolean
     */
    public function destroyForOwner($id, $ownerId);
    
    
}
