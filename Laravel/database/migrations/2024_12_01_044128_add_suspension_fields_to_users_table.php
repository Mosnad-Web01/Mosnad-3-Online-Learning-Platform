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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false); // هل المستخدم موقوف
            $table->text('suspension_reason')->nullable(); // سبب الإيقاف
            $table->timestamp('suspension_start_date')->nullable(); // بداية الإيقاف
            $table->timestamp('suspension_end_date')->nullable(); // نهاية الإيقاف
            $table->foreignId('suspended_by')->nullable()->constrained('users'); // المسؤول عن الإيقاف
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_suspended');
            $table->dropColumn('suspension_reason');
            $table->dropColumn('suspension_start_date');
            $table->dropColumn('suspension_end_date');
            $table->dropForeign(['suspended_by']);
            $table->dropColumn('suspended_by');
        });
    }
};
