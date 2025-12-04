<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // 1️⃣ CREATE ADMIN USER
        // ============================
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Admin User',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================
        // 2️⃣ CREATE CLIENT
        // ============================
        $clientId = DB::table('clients')->insertGetId([
            'name'       => 'Demo Client',
            'email'      => 'client@example.com',
            'phone'      => '9876543210',
            'company'    => 'Demo Company Ltd',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ============================
        // 3️⃣ CREATE PROJECT (MATCHES YOUR MIGRATION)
        // ============================
        $projectId = DB::table('projects')->insertGetId([
            'project_title'        => 'Demo Project',
            'project_description'  => 'This is a seeded demo project.',
            'project_clientid'     => $clientId,
            'project_start_date'   => Carbon::now()->toDateString(),
            'project_end_date'     => Carbon::now()->addDays(30)->toDateString(),
            'project_status'       => 'pending',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // ============================
        // 4️⃣ CREATE TASK (MATCHES YOUR TASK MIGRATION)
        // ============================
        DB::table('tasks')->insert([
            'task_title'        => 'Initial Setup Task',
            'task_description'  => 'This is a sample seeded task.',
            'task_projectid'    => $projectId,
            'task_creatorid'    => $adminId,
            'task_status'       => 'pending',
            'task_priority'     => 'medium',
            'task_due_date'     => Carbon::now()->addDays(7)->toDateString(),
            'task_created'      => now(),
            'task_updated'      => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
