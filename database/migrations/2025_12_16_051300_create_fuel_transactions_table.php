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
        Schema::create('fuel_transactions', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->decimal('liter_amount', 10, 2); // Decimal untuk liter
            $table->integer('price_per_liter');
            $table->integer('odometer_at_refuel');
            $table->text('note');

            // Foreign Keys
            $table->string('vehicle_id', 24);
            $table->string('driver_id', 24);

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('driver_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_transactions');
    }
};
