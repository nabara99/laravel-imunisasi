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
        Schema::table('student_targets', function (Blueprint $table) {
            $table->integer('year')->default(2025)->after('id_school');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_targets', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
