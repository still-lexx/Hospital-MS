<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            $admin->update(['role' => 'admin']);
            $this->command->info('Admin role updated successfully!');
        } else {
            $this->command->error('Admin user not found!');
        }
    }
}
