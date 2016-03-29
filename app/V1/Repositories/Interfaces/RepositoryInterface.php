<?php

namespace Sikasir\V1\Repositories\Interfaces;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

interface RepositoryInterface 
{
	public function setQuery(QueryCompanyInterface $query);
	
    /**
     * find a resource by id
     * 
     * @param integer $id
     */
    public function find($id);
    
    /**
     * save resource
     * 
     * @param array $data
     */
    public function save(array $data);
    
    /**
     * delete resource
     * 
     * @param array|integer $id
     */
    public function destroy($id);
    
    /**
     * get all resources
     * 
     * @param array $coloumns = ['*']
     */
    public function getAll(array $coloumns = ['*']);
    
    /**
     * get all resources paginated
     * 
     * @param integer $perPage = 10
     * @param array $with = []
     */
    public function getPaginated($with = [], $perPage = 10);
    
    
    public function update(array $data, $id);
   
}
