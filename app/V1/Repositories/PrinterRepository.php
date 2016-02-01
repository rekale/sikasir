<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Printer;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;


/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class PrinterRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use Traits\EloquentOwnerThroughable;
    
    public function __construct(Printer $model) 
    {
        parent::__construct($model);
    }
    
}
