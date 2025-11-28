<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add payment reference (if it doesn’t exist)
            if (!Schema::hasColumn('payments', 'payment_reference')) {
                $table->string('payment_reference', 100)->unique()->after('payment_id');
            }

            // Add client foreign key (if not existing)
            if (!Schema::hasColumn('payments', 'payment_clientid')) {
                $table->unsignedBigInteger('payment_clientid')->nullable()->after('payment_reference');
                $table->foreign('payment_clientid')->references('client_id')->on('clients')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }
            if (Schema::hasColumn('payments', 'payment_clientid')) {
                $table->dropForeign(['payment_clientid']);
                $table->dropColumn('payment_clientid');
            }
        });
    }
};
