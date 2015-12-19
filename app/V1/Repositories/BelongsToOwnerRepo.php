<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\User\Owner;

interface BelongsToOwnerRepo
{

     /**
     * find specific resource for owner
     * 
     * @param integer $id
     * @param Owner $owner
     * 
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function  findForOwner($id, Owner $owner);
    
    /**
     * get paginated resource for owner
     * 
     * @param Owner $owner
     * @param array $with
     */
    public function getPaginatedForOwner(Owner $owner, $with = []);
    
    /**
    * save the current model to owner
    *
    * @var array $date
    * @var Sikasir\V1\User\Owner
    *
    * @return void
    */
    public function saveForOwner(array $data, Owner $owner);
    
    /**
    * update the current model to owner
    *
    * @var integer $id
    * @var array $data
    * @var Sikasir\V1\User\Owner
    *
    * @return void
    */
    public function updateForOwner($id, array $data, Owner $owner);
    
    /**
     * delete specific resource that owner belong
     * 
     * @param integer $id
     * @param Owner $owner
     * 
     */
    public function destroyForOwner($id, Owner $owner);

}
