<?php

namespace Sikasir\V1\Repositories\Settings;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Transactions\Payment;
use Sikasir\V1\Repositories\Interfaces\OwnerableRepo;
use Sikasir\V1\Repositories\Interfaces\Reportable;
use Sikasir\V1\Repositories\Traits\EloquentOwnerable;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class PaymentRepository extends EloquentRepository implements OwnerableRepo, Reportable
{
    use EloquentOwnerable;

    public function __construct(Payment $model) 
    {
        parent::__construct($model);
    }

    public function getReportsForCompany($companyId, $dateRange, $outletId = null, $perPage = 15) {

        return $this->queryForOwner($companyId)
                    ->report($dateRange, $outletId)
                    ->paginate($perPage);
    }

}
