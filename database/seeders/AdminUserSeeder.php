<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Keep the setup account usable when the seeder is run more than once.
        User::updateOrCreate(
            ['email' => 'admin@marscollection.co.ke'],
            [
                'name' => 'Admin User',
                'password' => '@z4y4n5B34u7y.',
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin account is ready: admin@marscollection.co.ke');
    }
}
