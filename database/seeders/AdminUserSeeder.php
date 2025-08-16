<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@zaynsbeauty.co.ke',
            'password' => Hash::make('@z4y4n5B34u7y.'),
            'is_admin' => true,
        ]);


        $this->command->info('Admin users created successfully!');
        $this->command->info('Admin credentials: admin@zaynsbeauty.co.ke / @z4y4n5B34u7y.');
    }
} 