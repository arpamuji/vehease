<?php

use App\Enums\ApprovalStatus;
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
            $table->enum('status', array_column(ApprovalStatus::cases(), 'value'))->default(ApprovalStatus::PENDING->value);

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

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
