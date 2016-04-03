<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;
use Sikasir\V1\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class TempEloquentRepository implements RepositoryInterface
{
    /**
     *
     * @var Builder
     */
    protected $query;
   
    
    public function __construct(QueryCompanyInterface $query = null) 
    {
        $this->query = $query->forCompany();
    }
    
    public function setQuery(QueryCompanyInterface $query) 
    {
        $this->query = $query->forCompany();
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
        return $this->query->findOrFail($id);
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
        
        return $this->query->with($relations)->findOrFail($id);
    }

    /**
     * get resources paginated
     * 
     * @param integer $perPage
     * @return Paginator
     */
    public function getPaginated($with = [], $perPage = 15) {
        
        return $this->query->with($with)->paginate($perPage);
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
        return $this->findOrFail($id)
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
        return $this->query->whereId($id)->delete();
    }
    
    public function getAll(array $coloumns = array('*')) 
    {
        return $this->query->all($coloumns);
    }
    
    public function getSome($take, $skip = 0)
    {
       return $this->query->take($take)->skip($skip)->get();
    }
    
	public function search($field, $word, $with =[], $perPage = 15)
	{
		return $this->query->with($with)
						   ->where($field, 'LIKE', '%'.$word.'%')
						   ->paginate($perPage);
	}
	
	/**
	 * 
	 * @param string $value
	 */
	public function orderBy($value = null)
	{
		if(isset($value)) {
			$param = explode('|', $value);
			
			$this->query = $this->query->orderBy($param[0], $param[1]);
		}
		
		return $this;
	}

}
