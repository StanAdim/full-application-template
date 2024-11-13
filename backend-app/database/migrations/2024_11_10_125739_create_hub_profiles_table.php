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
        Schema::create('hub_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('hub_name');
            $table->string('uid');
            $table->string('total_members');
            $table->string('number_female');
            $table->string('membership_option');
            $table->json('available_programs')->nullable(); // JSON column for founders
            $table->boolean('status')->default(false);
            $table->longText('brief')->nullable();
            $table->longText('partnerships')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hub_profiles');
    }
};
