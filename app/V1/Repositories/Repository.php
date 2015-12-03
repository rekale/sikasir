<?php

namespace Sikasir\V1\Interfaces;

use \Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
    private $model;
    
    public function __construct(Model $model) {
        $this->model = $model;
    }
    
    
    /**
     * find specific resource by obfuascated id
     * 
     * @param integer $id
     * 
     * @return \Illuminate\Support\Collection|static;
     */
    public function find($id) 
    {
        $id = $this->decode($id);
        
        return $this->model->findOrFail($id);
    }
    
    /**
     * find specific resource by obfuascated id with its relationship
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
        
        return $this->model->save($data);
        
    }
    
    
     /**
     * delete resource
     * 
     * @param array|integer $id
     * 
     * @return boolean
     */
    public function destroy($id) {
        if (is_array($id)) {
            foreach ($id as $data => $value) {   
                $id[$data] = $this->decode($value);                
            }
        }
        else {
            $id = $this->decode($id);
        }
        
        return $this->model->destroy($id);
    }

    public function getAll(array $coloumns = array('*')) {
        return $this->model->all($coloumns);
    }
    
    public function getSome($take, $skip = 0)
    {
       return $this->model->take($take)->skip($skip)->get();
    }
   
}
