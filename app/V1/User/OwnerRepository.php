<?php

namespace Sikasir\V1\User;

use Sikasir\V1\Repositories\EloquentRepository;
use Sikasir\V1\User\User;
/**
 * Description of OutletRepository
 *
 * @author rekale
 */
class OwnerRepository extends EloquentRepository
{
    
    public function __construct(Owner $owner) 
    {
        parent::__construct($owner);
    }
    
    public function save(array $data) {
        
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        
        $owner = Owner::create($data);
        
        $owner->user()->save($user);
    }

}
