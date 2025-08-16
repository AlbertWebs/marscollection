<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminUsers = User::where('is_admin', true)->get();

        if ($adminUsers->isEmpty()) {
            $this->info('No admin users found.');
            return 0;
        }

        $this->info('Admin Users:');
        $this->info('');

        $headers = ['ID', 'Name', 'Email', 'Created At'];
        $rows = [];

        foreach ($adminUsers as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
                $user->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $this->table($headers, $rows);

        return 0;
    }
} 