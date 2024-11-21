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
        Schema::create('mobile_user_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('message_category_id')->unsigned();
            $table->foreign('message_category_id')->references('id')->on('message_categories')->onDelete('cascade');
            $table->boolean('activ')->default(1);
            $table->bigInteger('governing_body_id')->unsigned();
            $table->foreign('governing_body_id')->references('id')->on('governing_bodies')->onDelete('cascade');
            $table->string('socket_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_user_infos');
    }
};
