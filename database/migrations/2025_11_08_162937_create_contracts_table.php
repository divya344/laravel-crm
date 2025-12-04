<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('contract_id');
            $table->string('contract_title')->nullable();
            $table->text('contract_description')->nullable();
            $table->decimal('contract_value', 15, 2)->default(0);
            $table->dateTime('contract_start_date')->nullable();
            $table->dateTime('contract_end_date')->nullable();
            $table->string('contract_status')->default('draft');
            $table->unsignedBigInteger('contract_clientid')->nullable();
            $table->unsignedBigInteger('contract_projectid')->nullable();
            $table->unsignedBigInteger('contract_creatorid')->nullable();
            $table->timestamp('contract_created')->nullable();
            $table->timestamp('contract_updated')->nullable();
            $table->timestamp('doc_created')->nullable();
            $table->timestamp('doc_updated')->nullable();

            // Optional indexes
            $table->index(['contract_clientid']);
            $table->index(['contract_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
