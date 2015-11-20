<?php

use Illuminate\Database\Seeder;
use DCN\RBAC\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Admin sikasir', // optional
            'parent_id' => NULL, // optional, set to NULL by default
        ]);
        
        $owner = Role::create([
            'name' => 'Owner',
            'slug' => 'owner',
            'description' => 'pemilik perusahaan', // optional
            'parent_id' => $admin->id, // optional, set to NULL by default
        ]);
        
        $staff = Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'staff yang bekerja di perusahaan',
            'parent_id' => $owner->id,
        ]);
        
        $kasir = Role::create([
            'name' => 'Kasir',
            'slug' => 'kasir',
            'description' => 'kasir',
            'parent_id' => $staff->id,
        ]);
        
        
        
    }
}
