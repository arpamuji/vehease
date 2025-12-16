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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->string('class'); // ENUM: PASSENGER, CARGO
            $table->string('brand', 24);
            $table->string('model', 32);
            $table->text('license_number');
            $table->text('chasis_number');
            $table->text('engine_number');
            $table->text('color');
            $table->string('fuel_category'); // ENUM: DIESEL, GASOLINE, ELECTRIC

            // Foreign Key
            $table->string('location_id', 24);
            $table->foreign('location_id')->references('id')->on('locations');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
