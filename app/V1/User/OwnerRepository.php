<?php

namespace Sikasir\V1\User;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\User\User;
use Sikasir\V1\Repositories\UserMorphable;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OwnerRepository extends Repository
{
    
    public function __construct(Owner $owner) 
    {
        parent::__construct($owner);
    }

    public function createUser($id, array $data) 
    {
        $owner = $this->find($id);
        
        $owner->user()->save(new User($data));
    }

}
