<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('restrict');  // إذا تم حذف الدورة، سيتم منع الحذف
            $table->foreignId('student_id')->constrained('users')->onDelete('restrict');  // إذا تم حذف المستخدم، سيتم منع الحذف
            $table->timestamp('enrollment_date')->default(DB::raw('CURRENT_TIMESTAMP'));  // تاريخ التسجيل
            $table->timestamp('completion_date')->nullable();  // تاريخ الإتمام (قابل أن يكون فارغًا)
            $table->integer('progress')->default(0);  // نسبة التقدم
            $table->timestamps();  // تواريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');  // حذف الجدول في حالة التراجع عن الهجرة
    }
};
