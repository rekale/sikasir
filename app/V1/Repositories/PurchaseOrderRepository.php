<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\Stocks\PurchaseOrder;
use Sikasir\V1\Repositories\Interfaces\OwnerThroughableRepo;
/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class PurchaseOrderRepository extends EloquentRepository implements OwnerThroughableRepo
{
    use Traits\EloquentOwnerThroughable;
    
    public function __construct(PurchaseOrder $model) 
    {
        parent::__construct($model);
    }
    
    
   
    

}
