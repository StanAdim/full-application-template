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
        Schema::create('startup_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('startup_name');
            $table->string('industry');
            $table->string('uid');
            $table->string('funding_stage');
            $table->integer('team_size');
            $table->longText('description')->nullable();
            $table->json('founders')->nullable(); // JSON column for founders
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_profiles');
    }
};
