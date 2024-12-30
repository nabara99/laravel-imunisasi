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
        Schema::create('student_targets', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('classroom');
            $table->integer('sum_boys');
            $table->integer('sum_girls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_targets');
    }
};
