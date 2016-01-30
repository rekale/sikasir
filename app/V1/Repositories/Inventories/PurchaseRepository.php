<?php

namespace Sikasir\V1\Repositories\Inventories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerThroughable;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class PurchaseRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use EloquentOwnerThroughable;
    
    public function __construct(PurchaseOrder $model) 
    {
        parent::__construct($model);
    }
    
    

}
