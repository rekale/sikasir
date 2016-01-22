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
        'admins',
        'owners',
        'employees',
        'apps',
        'outlets',
        'business_fields',
        'taxes',
        'discounts',
        'employee_outlet',
        'incomes',
        'outcomes',
        'customers',
        'categories',
        'products',
        'variants',
        'stocks',
        'stock_details',
        'entries',
        'entry_stockdetail',
        'outs',
        'out_stockdetail',
        'opnames',
        'opname_stockdetail',
        'orders',
        'order_stockdetail',
        'suppliers',
        'printers',
    ];

    /**
     * @var array
     */
    protected $seeders = [
        'UserSeeder',
        'RolesSeeder',
        'FinanceSeeder',
        'CustomerSeeder',
        'ProductSeeder',
        'StockSeeder',
        'OrderSeeder',
        'SupplierSeeder',
        'PrinterSeeder',
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
