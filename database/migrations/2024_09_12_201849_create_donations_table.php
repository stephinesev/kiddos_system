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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->integer('donor_id')->default(0);
            $table->integer('event_id')->default(0);
            $table->string('when_date')->nullable();
            $table->string('when_time')->nullable();
            $table->string('barangay')->nullable();
            $table->string('donation_type')->nullable();
            $table->string('mode_of_collection')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
