<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name', 255);
            $table->text('description');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced']);
            $table->foreignId('category_id')->constrained('course_categories')->onDelete('restrict');
            $table->decimal('price', 10, 2);
            $table->boolean('is_free')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('language')->nullable(); // إضافة لغة الكورس
            $table->text('requirements')->nullable(); // إضافة متطلبات الكورس
            $table->text('learning_outcomes')->nullable(); // إضافة نتائج التعلم
            $table->timestamps();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('restrict');
            $table->string('image')->nullable(); // إضافة عمود الصورة
        });
    }
   
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
