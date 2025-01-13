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
        Schema::create('ibls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_children')->constrained('childrens')->onDelete('cascade');
            $table->date('pcv3')->nullable();
            $table->date('penta4')->nullable();
            $table->date('mr2')->nullable();
            $table->boolean('lengkap')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibls');
    }
};
