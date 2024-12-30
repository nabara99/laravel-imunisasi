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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();
            $table->string('name_child');
            $table->string('nik');
            $table->date('date_birth');
            $table->string('mother_name');
            $table->string('mother_nik');
            $table->string('address');
            $table->enum('gender', ['L', 'P']);
            $table->foreignId('id_village')->constrained('villages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
