<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('estimates', function (Blueprint $table) {
            if (!Schema::hasColumn('estimates', 'estimate_number')) {
                $table->string('estimate_number', 50)->unique()->nullable();
            }
            if (!Schema::hasColumn('estimates', 'client_name')) {
                $table->string('client_name')->nullable();
            }
            if (!Schema::hasColumn('estimates', 'bill_amount')) {
                $table->decimal('bill_amount', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('estimates', 'bill_status')) {
                $table->enum('bill_status', ['draft', 'sent', 'approved', 'rejected'])->default('draft');
            }
            if (!Schema::hasColumn('estimates', 'bill_notes')) {
                $table->text('bill_notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('estimates', function (Blueprint $table) {
            $table->dropColumn(['estimate_number', 'client_name', 'bill_amount', 'bill_status', 'bill_notes']);
        });
    }
};
