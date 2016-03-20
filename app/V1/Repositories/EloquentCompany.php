<?php

namespace Sikasir\V1\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class EloquentCompany implements Interfaces\QueryCompanyInterface
{
    /**
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;
    
    /**
     *
     * @var integer
     */
    private $companyId;
    
    /**
     * 
     * @param Model $model
     * @param integer $companyId
     */
    public function __construct(Model $model, $companyId) 
    {
        $this->model = $model;
        $this->companyId = $companyId;
    }
    
    /**
     * 
     * @return Builder
     */
    public function forCompany()
    {
        return $this->model->whereCompanyId($this->companyId);
    }

    /**
     * 
     * @param array $data
     * @return Model
     */
    public function dataForCompany(array $data) 
    {
        $data['company_id'] = $this->companyId;
        
        return $this->model->fill($data);
    }
    
    /**
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

}
