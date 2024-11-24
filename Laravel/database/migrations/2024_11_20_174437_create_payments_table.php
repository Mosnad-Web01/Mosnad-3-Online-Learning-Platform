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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // يربط الطالب
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // يربط الدورة
            $table->string('payment_method'); // طريقة الدفع
            $table->decimal('amount', 10, 2); // المبلغ المدفوع
            $table->enum('payment_status', ['completed', 'failed', 'pending'])->default('pending'); // حالة الدفع
            $table->timestamp('payment_date')->nullable(); // تاريخ الدفع
            $table->timestamps();
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
