<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories\Traits;

use Illuminate\Database\Connection as DB;

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
     * @param string $throughTableName
     * @param integer $companyId
     * @param integer $throughId
     * @param integer $with
     * @return type
     */
    public function findForOwnerThrough($id,  $throughTableName ,$companyId, $throughId, $with = [])
    {
        
    }
  
    /**
    * save the current model to company
    *
    * @param array $data
    * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
    *
    * @return static|boolean
    */
    public function saveForOwnerThrough(array $data, $companyId, $throughId, $throughTableName)
    {
        $throughTableExist = \DB::table($throughTableName)
                                ->where('id', $throughId)
                                ->where('company_id', $companyId)
                                ->exists();
        
        if($throughTableExist) {
            
            $foreignId = str_singular($throughTableName) . '_id';
            
            $data[$foreignId] = $throughId;
            
            return $this->model->create($data);
        
        }
        else
        {
            return false;
        }
        
    }
    
    /**
    * update the current model to company
    *
    * @param integer $id
    * @param array $data
    * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
    *
    * @return void
    */
    public function updateForOwnerThrough($id, array $data, $companyId, $throughId, $throughTableName)
    {
        return $this->model
                    ->whereExists(
                        function ($query) use($throughTableName, $companyId, $throughId) {

                            $modelForeignId = $this->model->getTable() . '.' . str_singular($throughTableName) . '_id';

                            $constraint = $throughTableName . '.id' . ' = ' . $modelForeignId;

                            $query->select(\DB::raw(1))
                                  ->from($throughTableName)
                                  ->where('id', '=', $throughId)
                                  ->where('company_id', '=', $companyId)
                                  ->whereRaw($constraint);
                    })
                    ->findOrFail($id)
                    ->update($data);
    }
    
    /**
     * delete specific resource that company belong
     * 
     * @param integer $id
     * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
     * 
     * return boolean
     */
    public function destroyForOwnerThrough($id, $companyId, $throughId, $throughTableName)
    {
        
    }
    
    
     /**
      * 
      * @param string $throughTableName
      * @param integer $companyId
      * @param integer $throughId
      * @param array $with
      * @param integer $perPage
      * 
      * @return Paginator
      */
     public function getPaginatedForOwnerThrough($throughTableName, $companyId, $throughId, $with = [], $perPage = 15)
     {
         return $this->model
                    ->whereExists(
                       function ($query) use($throughTableName, $companyId, $throughId) {

                           $modelForeignId = $this->model->getTable() . '.' . str_singular($throughTableName) . '_id';

                           $constraint = $throughTableName . '.id' . ' = ' . $modelForeignId;

                           $query->select(\DB::raw(1))
                                 ->from($throughTableName)
                                 ->where('id', '=', $throughId)
                                 ->where('company_id', '=', $companyId)
                                 ->whereRaw($constraint);
                   })
                   ->with($with)
                   ->paginate($perPage);
     }
    
}
