<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\User\Company;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;


/**
 * Description of ProductRepository
 *
 * @author rekale 
 *
 */
class CustomerRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;
    
    public function __construct(Customer $model) 
    {
        parent::__construct($model);
    }
    
   

}
