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
    Schema::create('lessons', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained('courses')->onDelete('restrict');
        $table->string('title');
        $table->text('content');
        $table->string('video_url')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('lessons');
}

};
