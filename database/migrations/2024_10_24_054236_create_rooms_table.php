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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobile_user_id')->unsigned();
            $table->foreign('mobile_user_id')->references('id')->on('mobile_users')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('message_category_id')->unsigned();
            $table->foreign('message_category_id')->references('id')->on('message_categories')->onDelete('cascade');

            $table->bigInteger('governing_body_id')->unsigned();
            $table->foreign('governing_body_id')->references('id')->on('governing_bodies')->onDelete('cascade');

            $table->boolean('status')->default(0);

            $table->string('mobile_user_name')->nullable();

            $table->bigInteger('operator_id')->unsigned();
            $table->foreign('operator_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('message_category_id')->unsigned();
            $table->foreign('message_category_id')->references('id')->on('message_categories')->onDelete('cascade');

            $table->boolean('activ')->default(1);

            $table->bigInteger('governing_body_id')->unsigned();
            $table->foreign('governing_body_id')->references('id')->on('governing_bodies')->onDelete('cascade');

            $table->string('email')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
