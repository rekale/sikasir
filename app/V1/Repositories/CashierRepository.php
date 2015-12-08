<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOwnerRepo; 
use Sikasir\V1\User\Cashier;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;
use Sikasir\V1\Repositories\UserMorphable;
use Sikasir\V1\Outlets\Outlet;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class CashierRepository extends Repository implements BelongsToOwnerRepo
{
    use \Sikasir\V1\Traits\IdObfuscater;
    
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        
        $data['outlet_id'] = $this->decode($data['outlet_id']);
        
        $user->cashier()->save(new Cashier($data));
        
        $cashier = $user->cashier;
        
        $owner->cashiers()->save($cashier);
    }

    public function getPaginatedForOwner(Owner $owner) 
    {
        return $owner->cashiers()->paginate();
    }

    public function findForOwner($id, Owner $owner) 
    {
        return $owner->cashiers()->findOrFail($this->decode($id));
    }
    
    public function updateForOwner($id, array $data, Owner $owner) 
    {
        $owner->cashiers()
                ->findOrFail($this->decode($id))
                ->update($data);
    }
    
    public function destroyForOwner($id, Owner $owner) 
    {
        $decodedId = $this->decode($id);
        
        $owner->cashiers()->findOrFail($decodedId);
        
        $this->destroy($id);
    }

}
