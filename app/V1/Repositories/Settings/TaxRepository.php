<?php

namespace Sikasir\V1\Repositories\Settings;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerable;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class TaxRepository extends EloquentRepository implements OwnerableRepo
{
    use EloquentOwnerable;

    public function __construct(Tax $model) 
    {
        parent::__construct($model);
    }

    public function search($field, $word, $with=[], $perPage=15)
    {
    	 
    }
    
}
