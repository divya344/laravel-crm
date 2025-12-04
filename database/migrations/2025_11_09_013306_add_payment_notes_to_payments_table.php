<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add the payment_notes column after payment_date
            if (!Schema::hasColumn('payments', 'payment_notes')) {
                $table->text('payment_notes')->nullable()->after('payment_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'payment_notes')) {
                $table->dropColumn('payment_notes');
            }
        });
    }
};
