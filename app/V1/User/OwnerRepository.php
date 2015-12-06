<?php

namespace Sikasir\V1\User;

use Sikasir\V1\Repositories\Repository;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OwnerRepository extends Repository
{
    
    public function __construct(Owner $owner) {
        parent::__construct($owner);
    }
    
  
}
