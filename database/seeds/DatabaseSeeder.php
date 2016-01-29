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
        'entries',
        'entry_product',
        'outs',
        'out_product',
        'opnames',
        'opname_product',
        'purchase_orders',
        'product_purchase_order',
        'orders',
        'order_product',
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
        'SupplierSeeder',
        'ProductSeeder',
        'StockSeeder',
        'OrderSeeder',
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
