<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {

            // Primary Key
            $table->bigIncrements('task_id');

            // Task Details
            $table->string('task_title');
            $table->text('task_description')->nullable();

            // Relations
            $table->unsignedBigInteger('task_projectid')->nullable();
            $table->unsignedBigInteger('task_creatorid')->nullable();

            // Task Status & Priority
            $table->string('task_status')->default('pending');   // pending | in_progress | completed | cancelled
            $table->string('task_priority')->default('medium');  // low | medium | high

            // Due Date
            $table->date('task_due_date')->nullable();

            // Custom timestamps required by your model
            $table->timestamp('task_created')->nullable();
            $table->timestamp('task_updated')->nullable();

            // Indexes
            $table->index('task_status');
            $table->index('task_priority');
            $table->index('task_projectid');

            // Optional FK constraints (uncomment ONLY if your tables exist)
            // $table->foreign('task_projectid')->references('project_id')->on('projects')->onDelete('cascade');
            // $table->foreign('task_creatorid')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
