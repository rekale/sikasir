<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TempEloquentRepository implements RepositoryInterface
{
    /**
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $query;
   
    
    public function __construct(QueryCompanyInterface $query) 
    {
        $this->query = $query;
    }
    
    /**
     * find specific resource by id
     * 
     * @param integer $id
     * 
     * @return Model;
     */
    public function find($id) 
    {   
        return $this->query->forCompany()->findOrFail($id);
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
        
        return $this->query->forCompany()->with($relations)->findOrFail($id);
    }

    /**
     * get resources paginated
     * 
     * @param integer $perPage
     * @return Paginator
     */
    public function getPaginated($with = [], $perPage = 15) {
        
        return $this->query->forCompany()->with($with)->paginate($perPage);
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
        return $this->query->forCompany()->findOrFail($id)
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
        return $this->query->getModel()->destroy($id);
    }
    
    public function getAll(array $coloumns = array('*')) 
    {
        return $this->query->forCompany()->all($coloumns);
    }
    
    public function getSome($take, $skip = 0)
    {
       return $this->query->forCompany()->take($take)->skip($skip)->get();
    }
    
   
}
