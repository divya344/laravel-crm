<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('subtasks', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('title');
            $table->boolean('completed')->default(false);

            $table->foreign('task_id')->references('task_id')->on('tasks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};
