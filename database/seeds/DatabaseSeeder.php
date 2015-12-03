<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
     
    protected $tables = [
        'users',
        'roles',
        'abilities',
        'role_abilities',
        'user_abilities',
        'owners',
        'employees',
        'apps',
        'outlets',
        'employee_outlet',
        'incomes',
        'outcomes',
        'customers',
        'product_categories',
        'products',
        'outlet_product',
        'product_variants',
    ];

    /**
     * @var array
     */
    protected $seeders = [
        'UserSeeder',
        'RolesSeeder',
        'OutletSeeder',
        'FinanceSeeder',
        'CustomerSeeder',
        'ProductSeeder',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->cleanPgsqlDatabase();

        foreach ($this->seeders as $seedClass)
        {
            $this->call($seedClass);
        }

        Model::reguard();
    }

    private function cleanMysqlDatabase()
    {
        
        $this->command->info('Truncating existing tables');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }

    private function cleanPgsqlDatabase()
    {
    
        $this->command->info('Truncating existing tables');
        DB::statement('TRUNCATE TABLE ' . implode(',', $this->tables). '  RESTART IDENTITY CASCADE;');
    
    }
}
