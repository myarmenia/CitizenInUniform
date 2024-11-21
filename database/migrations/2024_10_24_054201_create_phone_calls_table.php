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
        Schema::create('phone_calls', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->nullable();

            $table->bigInteger('mobile_user_id')->unsigned();
            $table->foreign('mobile_user_id')->references('id')->on('mobile_users')->onDelete('cascade');

            $table->bigInteger('governing_body_id')->unsigned();
            $table->foreign('governing_body_id')->references('id')->on('governing_bodies')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_calls');
    }
};
