<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            if (! Schema::hasTable('users')) {
                $sqlFile = database_path('setup.sql');
                if (file_exists($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    $statements = array_filter(array_map('trim', explode(';', $sql)));
                    foreach ($statements as $stmt) {
                        if (strlen($stmt) > 3) {
                            DB::unprepared($stmt.';');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // ignore
        }

        if (class_exists(\Database\Seeders\DemoSeeder::class)) {
            $this->call(\Database\Seeders\DemoSeeder::class);
        }
    }
}
