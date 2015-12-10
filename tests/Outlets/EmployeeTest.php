<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Sikasir\V1\Outlets\OutletRepository;
use Sikasir\V1\Transformer\EmployeeTransformer;

use Sikasir\V1\Outlets\Outlet;

class EmployeeTest extends TestCase
{
    
    use DatabaseTransactions, WithoutMiddleware, Sikasir\V1\Traits\IdObfuscater;
    
    /**
     * get outlet's product
     *
     * @return void
     */
    public function test_get_employees_that_working_in_one_outlet()
    {
        $repo = app(OutletRepository::class);
        
        $id = $repo->getSome(5)->random()->id;
        
        $outletId = $this->encode($id);
        
        $employees = $repo->getEmployees($id);
        
        $data = $this->createPaginated($employees, new EmployeeTransformer);
        
        $this->visit('v1/outlets/' . $outletId . '/employees');
        
        $this->seeJson($data->toArray());
        
        
    }
        
}
