<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Company;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Transactions\Payment;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $company = factory(Company::class)->create([
            'name' => 'owner',
            'username' => 'owner',
            'active' => true,
            'password' => bcrypt('owner'),
        ]);
        
        $owner = factory(User::class)->create([
            'name' => 'owner',
            'company_id' => $company->id, 
            'title' => 'owner',
            'email' => 'owner@sikasir.com',
            'password' => bcrypt('owner'),
        ]);
        
        $employees = factory(User::class, 5)->create([
            'company_id' => $company->id, 
            'password' => bcrypt('12345'),
        ]);
        
    }
    
}
