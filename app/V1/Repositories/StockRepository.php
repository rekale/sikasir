<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOwnerRepo; 
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class StockRepository extends Repository implements BelongsToOwnerRepo
{
    
    public function __construct(Stock $model) {
        parent::__construct($model);
    }

    public function destroyForOwner($id, Owner $owner) {
        
    }

    public function findForOwner($id, Owner $owner) {
        
    }

    public function getPaginatedForOwner(Owner $owner) {
        
    }

    public function saveForOwner(array $data, Owner $owner) {
        
    }

    public function updateForOwner($id, array $data, Owner $owner) {
        
    }

}
