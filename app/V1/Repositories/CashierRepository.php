<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class CashierRepository extends EloquentRepository
{
    
    public function __construct(Cashier $model) {
        parent::__construct($model);
    }

    public function saveForOwner(array $data, $ownerId)
    {
        \DB::transaction(function ($data, $ownerId){
        
            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $data['owner_id'] = $ownerId;

            $cashier = Cashier::create($data);

            $cashier->user()->save($user);
       
        });
         
    }

}
