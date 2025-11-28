<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Add missing lead columns safely
            if (!Schema::hasColumn('leads', 'lead_name')) {
                $table->string('lead_name')->nullable()->after('lead_id');
            }
            if (!Schema::hasColumn('leads', 'lead_email')) {
                $table->string('lead_email')->unique()->nullable()->after('lead_name');
            }
            if (!Schema::hasColumn('leads', 'lead_phone')) {
                $table->string('lead_phone', 25)->nullable()->after('lead_email');
            }
            if (!Schema::hasColumn('leads', 'lead_status')) {
                $table->enum('lead_status', ['new', 'contacted', 'qualified', 'converted', 'closed'])->default('new')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['lead_name', 'lead_email', 'lead_phone']);
        });
    }
};
