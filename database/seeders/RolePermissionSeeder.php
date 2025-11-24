<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions list
        $permissions = [
            'view patients',
            'add patients',
            'edit patients',
            'delete patients',

            'view appointments',
            'create appointments',
            'edit appointments',
            'cancel appointments',

            'manage users',
            'manage roles',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin - all permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Doctor
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'view patients',
            'edit patients',
            'view appointments',
            'create appointments',
            'edit appointments',
        ]);

        // Nurse
        $nurse = Role::firstOrCreate(['name' => 'nurse']);
        $nurse->givePermissionTo([
            'view patients',
            'view appointments',
        ]);

        // Receptionist
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->givePermissionTo([
            'add patients',
            'view patients',
            'create appointments',
            'cancel appointments',
        ]);
    }
}
