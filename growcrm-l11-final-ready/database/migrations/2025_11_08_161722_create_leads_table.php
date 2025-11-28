<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('lead_id');
            $table->string('lead_firstname')->nullable();
            $table->string('lead_lastname')->nullable();
            $table->unsignedBigInteger('lead_creatorid')->nullable();
            $table->unsignedBigInteger('lead_categoryid')->nullable();
            $table->string('lead_status')->default('new');
            $table->timestamp('lead_last_contacted')->nullable();
            $table->timestamp('lead_created')->nullable();
            $table->timestamp('lead_updated')->nullable();

            // Optional indexing for performance
            $table->index(['lead_creatorid']);
            $table->index(['lead_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
