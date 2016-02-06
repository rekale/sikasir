<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Products\Category;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class CategoryRepository extends EloquentRepository implements OwnerableRepo
{
    use Traits\EloquentOwnerable;

    public function __construct(Category $model) {
        parent::__construct($model);
    }
   
}
