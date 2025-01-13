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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name_student');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('nik');
            $table->string('mother_name');
            $table->string('mother_nik');
            $table->foreignId('id_school')->constrained('schools')->onDelete('cascade');
            $table->string('class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
