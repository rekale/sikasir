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
    
    
    public function queryForOwnerThrough($companyId, $throughId, $throughTableName)
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
                    });
    }
    /**
     * 
     * @param integer $id
     * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
     * @param array $with
     * @return static|collection
     */
    public function findForOwnerThrough($id, $companyId, $throughId, $throughTableName, $with = [])
    {
        return $this->queryForOwnerThrough($companyId, $throughId, $throughTableName)
                    ->with($with)
                    ->findOrFail($id);
    }
  
    /**
    * save the current model to company
    *
    * @param array $data
    * @param integer $companyId
     * @param integer $throughId
     * @param string $throughTableName
    *
    * @return static
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
            throw \Exception('through table does not exist');
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
        return $this->findForOwnerThrough($id, $companyId, $throughId, $throughTableName)
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
        return $this->findForOwnerThrough($id, $companyId, $throughId, $throughTableName)
                    ->delete();
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
         return $this->queryForOwnerThrough($id, $companyId, $throughId, $throughTableName)
                   ->with($with)
                   ->paginate($perPage);
     }
    
}
