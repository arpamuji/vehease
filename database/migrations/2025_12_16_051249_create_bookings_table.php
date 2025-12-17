<?php

use App\Enums\BookingStatus;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->enum('status', array_column(BookingStatus::cases(), 'value'))->default(BookingStatus::PENDING->value);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->text('note');

            // Foreign Keys
            $table->string('vehicle_id', 24);
            $table->string('driver_id', 24);
            $table->string('requester_id', 24);

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('driver_id')->references('id')->on('users');
            $table->foreign('requester_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
