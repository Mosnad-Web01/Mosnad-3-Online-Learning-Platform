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
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // يربط الطالب
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // يربط الدورة
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // حالة الدفع
            $table->decimal('amount_paid', 10, 2)->nullable(); // المبلغ المدفوع
            $table->timestamps();

            // مفتاح مركب للعلاقة بين الطالب والدورة
            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};
