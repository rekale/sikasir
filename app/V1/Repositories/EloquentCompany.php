<?php

namespace Sikasir\V1\Repositories;

use Illuminate\Database\Eloquent\Model;

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
    
    public function forCompany()
    {
        return $this->model->whereCompanyId($this->companyId);
    }

}
