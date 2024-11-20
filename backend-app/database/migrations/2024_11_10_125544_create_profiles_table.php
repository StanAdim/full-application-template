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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profileable_type'); // Polymorphic type
            $table->unsignedBigInteger('profileable_id'); // Polymorphic ID
            $table->boolean('status')->default(false);
            $table->string('uid');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('region')->nullable();
            $table->string('date_establishment')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
