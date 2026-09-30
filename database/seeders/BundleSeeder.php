<?php

namespace Database\Seeders;

use App\Models\Bundle;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        // Beauty bundles are not part of the footwear catalog.
        Bundle::query()->update(['is_active' => false]);
    }
}
