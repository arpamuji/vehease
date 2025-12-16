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
        Schema::create('approvals', function (Blueprint $table) {
            $table->string('id', 24)->primary();
            $table->integer('level');
            $table->string('status'); // ENUM: PENDING, APPROVED, REJECTED

            // Saya set nullable karena saat baru dibuat (PENDING), belum ada waktu approval
            $table->timestamp('approved_at')->nullable();

            // Foreign Keys
            // Koreksi: Saya samakan jadi 24 char sesuai ID users & bookings
            $table->string('approver_id', 24);
            $table->string('booking_id', 24);

            $table->foreign('approver_id')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('bookings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
