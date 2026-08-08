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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->enum('type', ['electronic', 'hybrid'])->default('electronic');
            $table->boolean('is_sequential')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->foreignId('program_id')->constrained('programs')->onDelete('restrict');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
