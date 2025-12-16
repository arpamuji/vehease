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
        Schema::create('trips', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->string('category'); // ENUM: DEPARTURE, ARRIVAL
            $table->integer('odometer');

            // Foreign Keys
            $table->string('vehicle_id', 24);
            $table->string('booking_id', 24);

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('booking_id')->references('id')->on('bookings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
