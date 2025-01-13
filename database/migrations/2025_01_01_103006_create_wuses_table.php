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
        Schema::create('wuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_wus');
            $table->string('nik');
            $table->date('date_birth');
            $table->string('address');
            $table->foreignId('id_village')->constrained('villages')->onDelete('cascade');
            $table->boolean('hamil')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wuses');
    }
};
