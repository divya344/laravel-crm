<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('task_files', function (Blueprint $table) {

            $table->bigIncrements('file_id');
            $table->unsignedBigInteger('task_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamp('uploaded_at')->useCurrent();

            $table->foreign('task_id')->references('task_id')->on('tasks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_files');
    }
};
