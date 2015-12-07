<?php

namespace Sikasir\V1\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @author rekale
 */
interface UserMorphable {
    
    /**
     * create new user
     * 
     * 
     * @param integer $id
     * @param array $data
     */
    public function createUser($id, array $data);
    
}
