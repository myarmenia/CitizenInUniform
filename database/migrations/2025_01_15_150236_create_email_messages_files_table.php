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
        Schema::create('email_messages_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('email_message_id')->unsigned();
            $table->foreign('email_message_id')->references('id')->on('email_messages')->onDelete('cascade');
            $table->string('path');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_messages_files');
    }
};
