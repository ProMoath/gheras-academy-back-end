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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('session_id')->index()->constrained('attendance_sessions')->onDelete('cascade');
            $table->enum('status', ['confirmed', 'flagged', 'rejected'])->default('confirmed');
            $table->decimal('gps_lat', 10, 8)->nullable();
            $table->decimal('gps_lng', 11, 8)->nullable();
            $table->decimal('distance_from_session', 8, 2)->nullable();
            $table->timestamp('scanned_at')->nullable();
            $table->enum('source', ['qr', 'manual', 'video'])->default('qr');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
