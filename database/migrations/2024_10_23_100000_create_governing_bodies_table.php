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
        Schema::create('governing_bodies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('named');
            $table->string('path');
            $table->boolean('email')->default(0);
            $table->boolean('phone')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('governing_bodies');
    }
};
