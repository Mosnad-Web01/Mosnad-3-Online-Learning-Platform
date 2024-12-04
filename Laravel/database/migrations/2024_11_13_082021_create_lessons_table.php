<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('restrict');
            $table->string('title'); // عنوان الدرس
            $table->text('content')->nullable(); // النص الأساسي
            $table->string('video_path')->nullable(); // مسار الفيديو
            $table->json('files')->nullable(); // مسارات الملفات (JSON)
            $table->json('images')->nullable(); // مسارات الصور (JSON)
            $table->integer('order')->default(0); // ترتيب الدرس
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
