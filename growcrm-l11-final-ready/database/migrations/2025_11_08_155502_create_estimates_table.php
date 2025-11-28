<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estimates', function (Blueprint $table) {
            // Primary key
            $table->bigIncrements('bill_estimateid');

            // Relationships (optional foreign keys)
            $table->unsignedBigInteger('bill_creatorid')->nullable();
            $table->unsignedBigInteger('bill_clientid')->nullable();
            $table->unsignedBigInteger('bill_categoryid')->nullable();
            $table->unsignedBigInteger('estimate_projectid')->nullable();

            // Estimate Information
            $table->string('estimate_number', 50)->unique(); // e.g. EST-1001
            $table->string('client_name', 255)->nullable();
            $table->decimal('bill_amount', 12, 2)->default(0);
            $table->enum('bill_status', ['draft', 'sent', 'approved', 'rejected'])->default('draft');

            // Dates
            $table->dateTime('bill_date')->nullable();          // Issue date
            $table->dateTime('bill_expiry_date')->nullable();   // Expiry date

            // Notes or description
            $table->text('bill_notes')->nullable();

            // Timestamps (CRM style)
            $table->timestamp('bill_created')->useCurrent();
            $table->timestamp('bill_updated')->useCurrent()->useCurrentOnUpdate();

            // Indexes
            $table->index(['bill_creatorid']);
            $table->index(['bill_clientid']);
            $table->index(['estimate_projectid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
