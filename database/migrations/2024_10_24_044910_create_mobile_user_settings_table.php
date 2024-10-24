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
        Schema::create('mobile_user_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobile_user_id')->unsigned();
            $table->foreign('mobile_user_id')->references('id')->on('mobile_users')->onDelete('cascade');
            $table->bigInteger('setting_id')->unsigned();
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_user_settings');
    }
};
