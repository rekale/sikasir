<?php


namespace Sikasir\V1\Factories;

use Illuminate\Database\Eloquent\Model;
use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;

class EloquentFactory
{
    protected $query;
    protected $data;
    /**
     *
     * @var Model
     */
    protected $model;
    
    public function __construct(QueryCompanyInterface $query) 
    {
        $this->query = $query;
    }
    
    /**
     * 
     * @param array $data
     * 
     * @return Model
     */
    public function create(array $data)
    {
        $savedData = $this->query->dataForCompany($data);
            
        return $savedData->save();
    }
    
}
