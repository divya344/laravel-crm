<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_label_map', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('label_id');
            $table->timestamps();

            $table->foreign('task_id')
                ->references('task_id')
                ->on('tasks')
                ->onDelete('cascade');

            $table->foreign('label_id')
                ->references('id')
                ->on('task_labels')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_label_map');
    }
};
