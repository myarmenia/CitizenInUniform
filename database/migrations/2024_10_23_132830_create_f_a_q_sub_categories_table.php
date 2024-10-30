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
        Schema::create('f_a_q_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('f_a_q_category_id')->unsigned();
            $table->foreign('f_a_q_category_id')->references('id')->on('f_a_q_categories')->onDelete('cascade');
            $table->mediumText('title');
            $table->longText('content');
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_q_sub_categories');
    }
};
