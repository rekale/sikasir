<?php

namespace Sikasir\V1\Repositories;

use \Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Repositories\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface
{
    
    protected $model;
   
    public function __construct(Model $model) {
        $this->model = $model;
    }
    
    
    /**
     * find specific resource by id
     * 
     * @param integer $id
     * 
     * @return \Illuminate\Support\Collection|static;
     */
    public function find($id) 
    {   
        return $this->model->findOrFail($id);
    }
    
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
    
    /**
     * find specific resource by id with its relationship
     * 
     * @param integer $id
     * 
     * @return @return \Illuminate\Support\Collection
     */
    public function findWith($id, array $relations)
    {
        
        return $this->model->with($relations)->findOrFail($id);
    }

    /**
     * get resources paginated
     * 
     * @param integer $perPage
     * @return Paginator
     */
    public function getPaginated($with = [], $perPage = 15) {
        
        return $this->model->with($with)->paginate($perPage);
    }

    /**
     * save new resource
     * 
     * @param array $data
     * @return static
     */
    public function save(array $data) {
        
        return $this->model->create($data);
        
    }
    
    /**
     * save new resource
     * 
     * @param array $data
     * @param integer $id
     * 
     * @return boolean
     */
    public function update(array $data, $id) 
    {
        return $this->model->findOrFail($id)
                ->update($data);    
    }
    
    
     /**
     * delete resource
     * 
     * @param array|integer $id
     * 
     * @return boolean
     */
    public function destroy($id) 
    {
        return $this->model->destroy($id);
    }
    
    public function getAll(array $coloumns = array('*')) 
    {
        return $this->model->all($coloumns);
    }
    
    public function getSome($take, $skip = 0)
    {
       return $this->model->take($take)->skip($skip)->get();
    }
    
   
}