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
    Schema::create('lesson_progress', function (Blueprint $table) {
        $table->id();
        $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
        $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('lesson_progress');
}

};
