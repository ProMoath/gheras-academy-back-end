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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cliq', 'manual', 'electronic'])->default('cliq');
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->string('transaction_id')->nullable()->unique()->index();
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->index()->constrained('courses')->onDelete('cascade');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
