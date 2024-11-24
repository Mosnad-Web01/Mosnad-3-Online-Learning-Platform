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
        Schema::create('lesson_completions', function (Blueprint $table) {
            $table->id(); // مفتاح أساسي
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade'); // تسجيل الطالب
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade'); // الدرس
            $table->timestamps(); // تاريخ الإكمال
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_completions');
    }
};
