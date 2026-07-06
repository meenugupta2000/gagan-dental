<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage company',
            'manage hero',
            'manage about',
            'manage features',
            'manage testimonials',
            'manage video testimonials',
            'manage faqs',
            'manage achievements',
            'manage blogs',
            'manage pages',
            'manage subscribers',
            'manage messages',
            'manage templates',
            'manage treatment categories',
            'manage treatments',
            'manage offers',
            'manage appointments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super Admin — bypasses all checks via Gate::before, but we still
        // give it every permission for completeness.
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin — full content/back-office access except role management.
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'view dashboard',
            'manage users',
            'manage company',
            'manage hero',
            'manage about',
            'manage features',
            'manage testimonials',
            'manage video testimonials',
            'manage faqs',
            'manage achievements',
            'manage blogs',
            'manage pages',
            'manage subscribers',
            'manage messages',
            'manage templates',
            'manage treatment categories',
            'manage treatments',
            'manage offers',
            'manage appointments',
        ]);

        // Receptionist — front-desk access: appointments and enquiries only.
        $receptionist = Role::firstOrCreate(['name' => 'receptionist', 'guard_name' => 'web']);
        $receptionist->syncPermissions(['view dashboard', 'manage appointments', 'manage messages']);
    }
}
