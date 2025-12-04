<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Call your demo/default seeders ---
        $this->call([
            DemoSeeder::class,
        ]);
    }
}
