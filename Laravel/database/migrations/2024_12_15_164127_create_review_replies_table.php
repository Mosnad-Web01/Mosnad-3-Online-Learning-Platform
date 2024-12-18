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
    Schema::create('review_replies', function (Blueprint $table) {
        $table->id();
        $table->foreignId('review_id')->constrained()->onDelete('cascade'); // ربط الرد بالمراجعة
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط الرد بالمستخدم
        $table->text('reply_text'); // نص الرد
        $table->foreignId('parent_id')->nullable()->constrained('review_replies')->onDelete('cascade'); // ربط الردود المتداخلة
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('review_replies');
}

};
