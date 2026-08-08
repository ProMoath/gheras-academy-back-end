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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('file_url');
            $table->json('placeholders')->nullable();
            $table->integer('font_size')->default(16);
            $table->string('font_color')->default('#000000');
            $table->foreignId('program_id')->index()->constrained('programs')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
