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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique()->index();
            $table->timestamp('issued_at')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('program_id')->index()->constrained('programs')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('certificate_templates')->onDelete('cascade');
            $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
