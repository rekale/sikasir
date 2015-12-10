<?php

namespace Sikasir\V1\Repositories;

use \Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Repositories\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    
    private $model;
    
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
     * find specific resource by id with its relationship
     * 
     * @param integer $id
     * 
     * @return @return \Illuminate\Support\Collection
     */
    public function findWith($id, array $relations)
    {
        
        return $this->find($id)->with($relations)->get();
    }

    /**
     * get resources paginated
     * 
     * @param integer $perPage
     * @return Paginator
     */
    public function getPaginated($perPage = 10) {
        return $this->model->paginate($perPage);
    }

    /**
     * save new resource
     * 
     * @param array $data
     * @return boolean
     */
    public function save(array $data) {
        
        $this->model->fill($data);
        
        return $this->model->save();
        
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
