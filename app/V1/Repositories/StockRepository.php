<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class StockRepository extends EloquentRepository
{
    
    public function __construct(StockDetail $model) {
        parent::__construct($model);
    }
    

}
