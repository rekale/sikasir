<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOwner; 
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;
use Sikasir\V1\Repositories\UserMorphable;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class CashierRepository extends Repository implements BelongsToOwner, UserMorphable
{

    public function __construct(Cashier $model) {
        parent::__construct($model);
    }

    /**
     * save cashier
     *
     * @param array $data
     * @param Sikasir\V1\User\Owner $owner
     *
     * @return void
     */
    public function saveForOwner(array $data, Owner $owner)
    {
        $owner->cashiers()->save(new Cashier($data));
    }

    public function createUser($id, array $data) 
    { 
       $cashier = $this->find($id);
        
        $cashier->user()->save(new User($data));
    }

}