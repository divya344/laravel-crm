<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->string('payment_reference')->unique();
            $table->decimal('payment_amount', 15, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_status')->default('pending');
            $table->unsignedBigInteger('payment_invoiceid')->nullable();
            $table->unsignedBigInteger('payment_clientid')->nullable();
            $table->unsignedBigInteger('payment_creatorid')->nullable();
            $table->timestamp('payment_created')->nullable();
            $table->timestamp('payment_updated')->nullable();

            // Optional indexes
            $table->index(['payment_status']);
            $table->index(['payment_method']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
