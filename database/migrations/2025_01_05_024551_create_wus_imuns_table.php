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
        Schema::create('wus_imuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_wus')->constrained('wuses')->onDelete('cascade');
            $table->date('t1')->nullable();
            $table->boolean('t1_status')->default(false);
            $table->date('t2')->nullable();
            $table->boolean('t2_status')->default(false);
            $table->date('t3')->nullable();
            $table->boolean('t3_status')->default(false);
            $table->date('t4')->nullable();
            $table->boolean('t4_status')->default(false);
            $table->date('t5')->nullable();
            $table->boolean('t5_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wus_imuns');
    }
};
