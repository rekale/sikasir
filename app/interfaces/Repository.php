<?php

namespace Sikasir\Intefaces;

use \Illuminate\Database\Eloquent\Model;
use Sikasir\Interfaces\RepositoryInterface;

class Repository implements RepositoryInterface
{
    use \Sikasir\Traits\IdObfuscater;
    
    protected $model;
    
    
    /**
     * find specific resource by id
     * 
     * @param integer $id
     * 
     * @return \Illuminate\Database\Eloquent\Collection|static[];
     */
    public function find($id) 
    {
        $data = $this->decode($id);
        
        return $this->model->find($data);
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
     * 
     * @param array $coloumns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($coloumns = ['*']) {
        return $this->model->all($coloumns);
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

}
