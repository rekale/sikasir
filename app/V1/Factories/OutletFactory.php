<?php


namespace Sikasir\V1\Factories;

use Sikasir\V1\Repositories\Interfaces\QueryCompanyInterface;
use Sikasir\V1\Factories\EloquentFactory;
use Sikasir\V1\Util\Obfuscater;
use Sikasir\V1\Outlets\Outlet;

class OutletFactory extends EloquentFactory
{
    public function __construct(Outlet $model) 
    {
        parent::__construct($model);
    }

    public function create(array $data) 
    {
        return $this->model->create($data);
    }

}
