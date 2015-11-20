<?php

namespace Sikasir\User;

use Sikasir\Interfaces\Repository;
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
