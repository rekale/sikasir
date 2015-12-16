<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class StockRepository extends Repository
{
    
    public function __construct(Stock $model) {
        parent::__construct($model);
    }
    

}
