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
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique()->index();
            $table->string('qr_code')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->decimal('location_lat', 10, 8)->nullable();
            $table->decimal('location_lng', 11, 8)->nullable();
            $table->foreignId('course_id')->index()->constrained('courses')->onDelete('cascade');
            $table->foreignId('created_by')->index()->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
