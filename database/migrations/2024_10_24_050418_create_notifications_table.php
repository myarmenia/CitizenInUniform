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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('setting_id')->unsigned()->nullable();
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->bigInteger('mobile_user_id')->unsigned();
            $table->foreign('mobile_user_id')->references('id')->on('mobile_users')->onDelete('cascade');
            $table->bigInteger('governing_body_id')->unsigned();
            $table->foreign('governing_body_id')->references('id')->on('governing_bodies');
            $table->mediumText('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('key');
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
