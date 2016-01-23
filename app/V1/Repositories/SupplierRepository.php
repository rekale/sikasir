<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Suppliers\Supplier;

/**
 * Description of EmployeeRepository
 *
 * @author rekale
 */
class SupplierRepository extends EloquentRepository
{
    public function __construct(Supplier $model) 
    {
        parent::__construct($model);
    }

}
