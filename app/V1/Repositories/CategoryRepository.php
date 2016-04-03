<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Repositories\Interfaces\ReportableRepo;
use Sikasir\V1\Products\Category;

/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class CategoryRepository extends EloquentRepository implements OwnerableRepo, ReportableRepo
{
    use Traits\EloquentOwnerable;

    public function __construct(Category $model) {
        parent::__construct($model);
    }
    
    public function getReportsForCompany($companyId, $dateRange, $outletId = null, $perPage = 15)
    {
        return $this->queryForOwner($companyId)
                    ->getTotalAndAmounts($dateRange, $outletId)
                    ->paginate($perPage);
    }
    
    public function search($field, $word, $with=[], $perPage=15)
    {
    	
    }
    
}
