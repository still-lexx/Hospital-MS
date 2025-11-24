<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminExists = User::where('email', 'admin@admin.com')->first();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@admin.com');
            $this->command->info('Password: admin');
            $this->command->info('Role: admin (Full System Access)');
        } else {
            $this->command->warn('Admin user already exists!');
        }
    }
}
