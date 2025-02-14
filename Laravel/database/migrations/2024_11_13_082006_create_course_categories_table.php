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
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('image')->nullable();  // إضافة الحقل لصورة الفئة
            $table->text('description')->nullable();  // إضافة الحقل للوصف
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_categories');
    }
};
