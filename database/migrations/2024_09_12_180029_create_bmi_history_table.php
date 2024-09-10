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
        Schema::create('bmi_history', function (Blueprint $table) {
            $table->id();
            $table->integer('beneficiary_id')->default(0);
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('bmi')->nullable();
            $table->string('nutritional_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bmi_history');
    }
};
