<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {

            $table->bigIncrements('ticket_id');

            $table->unsignedBigInteger('ticket_clientid')->nullable();
            $table->unsignedBigInteger('ticket_projectid')->nullable();
            $table->unsignedBigInteger('ticket_userid')->nullable();

            $table->string('ticket_subject');
            $table->text('ticket_message')->nullable();

            $table->enum('ticket_status', [
                'open',
                'in_progress',
                'answered',
                'closed'
            ])->default('open');

            $table->timestamps();

            // FK (optional — based on your schema)
            $table->foreign('ticket_clientid')->references('client_id')->on('clients')->onDelete('set null');
            $table->foreign('ticket_projectid')->references('project_id')->on('projects')->onDelete('set null');
            $table->foreign('ticket_userid')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
