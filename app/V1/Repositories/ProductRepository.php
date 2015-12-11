<?php

namespace Sikasir\V1\Repositories;

use Sikasir\V1\Repositories\Repository;
use Sikasir\V1\Repositories\BelongsToOutletRepo;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Outlets\Outlet;

/**
 * Description of OutletRepository
 *
 * @author rekale  public function __construct(Cashier $model) {
  
 */
class ProductRepository extends Repository implements BelongsToOutletRepo
{
    
    public function __construct(Product $model) 
    {
        parent::__construct($model);
    }

    public function destroyForOutlet($id, Outlet $outlet) {
        
    }

    public function findForOutlet($id, Outlet $outlet) {
        
    }

    public function getPaginatedForOutlet(Outlet $outlet) {
        
    }

    public function saveForOutlet(array $data, Outlet $outlet) {
        
    }

    public function updateForOutlet($id, array $data, Outlet $outlet) {
        
    }

}
