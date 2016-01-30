<?php

namespace Sikasir\V1\Repositories\Inventories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerThroughable;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class OpnameRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use EloquentOwnerThroughable;
    
    public function __construct(Opname $model) 
    {
        parent::__construct($model);
    }
    
    

}
