<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('channel')->nullable(); // for simple group tags or rooms
            $table->text('body')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();

            $table->index(['sender_id', 'receiver_id']);
            $table->index('channel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
