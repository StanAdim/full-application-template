<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Creating roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole = Role::create(['name' => 'approver']);
        $userRole = Role::create(['name' => 'user']);
        $userRole = Role::create(['name' => 'entity']);
        $userRole = Role::create(['name' => 'facilitator']);

        // Creating permissions
        $createPostPermission = Permission::create(['name' => 'create post']);
        $editPostPermission = Permission::create(['name' => 'edit post']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['create post', 'edit post']);
        $userRole->givePermissionTo('create post');
    }

    
}
