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
class CashierRepository extends Repository implements BelongsToOwnerRepo
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
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        
        $data['owner_id'] = $owner->id;
        
        $cashier = Cashier::create($data);
        
        $cashier->user()->save($user);
        
    }

    public function getPaginatedForOwner(Owner $owner, $with = []) 
    {
        return $owner->cashiers()->with($with)->paginate();
    }

    public function findForOwner($id, Owner $owner) 
    {
        return $owner->cashiers()->findOrFail($id);
    }
    
    public function updateForOwner($id, array $data, Owner $owner) 
    {
        $owner->cashiers()
                ->findOrFail($id)
                ->update($data);
    }
    
    public function destroyForOwner($id, Owner $owner) 
    {   
        $owner->cashiers()->findOrFail($id);
        
        $this->destroy($id);
    }

}
