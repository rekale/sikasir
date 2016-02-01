<?php

namespace Sikasir\V1\Repositories\Settings;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Repositories\Traits\EloquentOwnerable;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class DiscountRepository extends EloquentRepository implements OwnerableRepo
{
    use EloquentOwnerable;

    public function __construct(Discount $model) {
        parent::__construct($model);
    }
   
    
}
