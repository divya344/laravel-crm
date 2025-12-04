<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {

            // Add column anywhere (no AFTER)
            if (!Schema::hasColumn('tasks', 'task_created')) {
                $table->timestamp('task_created')->nullable();
            }

            if (!Schema::hasColumn('tasks', 'task_updated')) {
                $table->timestamp('task_updated')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'task_created')) {
                $table->dropColumn('task_created');
            }

            if (Schema::hasColumn('tasks', 'task_updated')) {
                $table->dropColumn('task_updated');
            }
        });
    }
};
