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
        $entity = Role::create(['name' => 'entity']);
        $facilitator = Role::create(['name' => 'facilitator']);
        $promotor = Role::create(['name' => 'promotor']);

        // Creating permissions
        Permission::create(['name' => 'create post']);
        $projectPermissions = [
            ['name' => 'create_project'],
            ['name' => 'edit_project'],
            ['name' => 'view_project'],
            ['name' => 'delete_project'],
            ['name' => 'approve_project'],
            ['name' => 'all_project'],
            ['name' => 'rate_project'],
        ];
        foreach ($projectPermissions as $item) Permission::create($item);
        $productPermissions = [
            ['name' => 'create_product'],
            ['name' => 'edit_product'],
            ['name' => 'view_product'],
            ['name' => 'delete_product'],
            ['name' => 'approve_product'],
            ['name' => 'all_product'],
            ['name' => 'rate_product'],
        ];
        foreach ($productPermissions as $item) Permission::create($item);

        $programmePermissions = [
            ['name' => 'create_programme'],
            ['name' => 'edit_programme'],
            ['name' => 'view_programme'],
            ['name' => 'delete_programme'],
            ['name' => 'approve_programme'],
            ['name' => 'all_programme'],
            ['name' => 'apply_programme'],
            ['name' => 'view_programme_applicants'],
        ];
        foreach ($programmePermissions as $item) Permission::create($item);

        $specialPermissions = [
            ['name' => 'view_profile'],
            ['name' => 'approve_profile'],
            ['name' => 'delete_profile'],
            ['name' => 'disable_user'],
            ['name' => 'delete_user'],
        ];
        foreach ($specialPermissions as $item) Permission::create($item);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
                'approve_programme',
                'delete_programme',
                'view_programme',
                'delete_project',
                'approve_project',
                'approve_product',
                'approve_profile',
                'delete_profile',
                'delete_user',
                'disable_user',
            ]
        );
        $promotor->givePermissionTo([
            'create_programme', 'edit_programme',
            'delete_programme', "view_programme",
            'view_programme_applicants'
        ]);
        $entity->givePermissionTo([
            'apply_programme', 'view_programme',
            'create_project', 'edit_project',
            'delete_project', 'view_project',
            'create_product', 'edit_product',
            'delete_product', 'view_project',
        ]);
    }

    
}
