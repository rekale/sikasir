<?php

namespace Sikasir\V1\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class NoCompany implements Interfaces\QueryCompanyInterface
{
    /**
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;
 
    /**
     * 
     * @param Model $model
     */
    public function __construct($model) 
    {
        $this->model = $model;
    }
    
    /**
     * 
     * @return Builder
     */
    public function forCompany()
    {
        return $this->model;
    }

    /**
     * 
     * @param array $data
     * @return Model
     */
    public function dataForCompany(array $data) 
    {   
        return $this->model->fill($data);
    }

}
