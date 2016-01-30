<?php

namespace Sikasir\V1\Repositories\Inventories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerThroughable;

/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class EntryRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use EloquentOwnerThroughable;
    
    public function __construct(Entry $entry) 
    {
        parent::__construct($entry);
    }
    
    

}
