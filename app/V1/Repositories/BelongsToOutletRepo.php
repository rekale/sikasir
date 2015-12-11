<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Outlets\Outlet;

interface BelongsToOutletRepo
{

     /**
     * find specific resource for outlet
     * 
     * @param integer $id
     * @param Outlet $outlet
     * 
     * @return \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function  findForOutlet($id, Outlet $outlet);
    
    /**
     * get paginated resource for outlet
     * 
     * @param Outlet $outlet
     */
    public function getPaginatedForOutlet(Outlet $outlet);
    
    /**
    * save the current model to outlet
    *
    * @var array $date
    * @var Sikasir\V1\User\Outlet
    *
    * @return void
    */
    public function saveForOutlet(array $data, Outlet $outlet);
    
    /**
    * update the current model to outlet
    *
    * @var integer $id
    * @var array $data
    * @var Sikasir\V1\User\Outlet
    *
    * @return void
    */
    public function updateForOutlet($id, array $data, Outlet $outlet);
    
    /**
     * delete specific resource that outlet belong
     * 
     * @param integer $id
     * @param Outlet $outlet
     * 
     */
    public function destroyForOutlet($id, Outlet $outlet);

}
