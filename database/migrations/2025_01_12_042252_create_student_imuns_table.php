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
        Schema::create('student_imuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_student')->constrained('students')->onDelete('cascade');
            $table->date('dt')->nullable();
            $table->date('mr')->nullable();
            $table->date('td1')->nullable();
            $table->date('td2pa')->nullable();
            $table->date('td2pi')->nullable();
            $table->date('hpv1')->nullable();
            $table->date('hpv2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_imums');
    }
};
