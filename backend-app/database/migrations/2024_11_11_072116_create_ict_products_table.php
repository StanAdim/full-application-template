<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ict_products', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('name');
            $table->json('category');
            $table->boolean('is_launched');
            $table->string('launched_date');
            $table->longText('description');
            $table->longText('compliance_details');
            
            $table->json('technicalSpecs')->nullable();
            $table->json('targetAudience')->nullable();
            $table->json('intellectualProp')->nullable();
            $table->json('supportingMedia')->nullable();

            $table->string('users_impression');
            $table->boolean('verify')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ict_products');
    }
};
