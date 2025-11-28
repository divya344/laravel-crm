<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {

            // Primary Key
            $table->bigIncrements('project_id');

            // Correct field names (used by your controller & views)
            $table->string('project_title');
            $table->text('project_description')->nullable();

            // Correct FK naming
            $table->unsignedBigInteger('project_clientid')->nullable();

            $table->date('project_start_date')->nullable();
            $table->date('project_end_date')->nullable();

            // Status
            $table->enum('project_status', [
                'pending',
                'in_progress',
                'completed',
                'on_hold'
            ])->default('pending');

            $table->timestamps();

            // FK → clients table
            $table->foreign('project_clientid')
                ->references('client_id')
                ->on('clients')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
