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
    
    public function save(array $data) {
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        
        $user->owner()->save(new Owner($data));
    }

}
