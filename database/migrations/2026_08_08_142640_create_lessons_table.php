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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_source')->default('youtube');
            $table->text('text_content')->nullable();
            $table->string('pdf_url')->nullable();
            $table->integer('duration')->default(0);
            $table->integer('order_index')->default(0);
            $table->boolean('is_sequential')->default(true);
            $table->integer('required_completion')->default(80);
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
