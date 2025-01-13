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
        Schema::create('idls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_children')->constrained('childrens')->onDelete('cascade');
            $table->date('hb0')->nullable();
            $table->date('bcg')->nullable();
            $table->date('polio1')->nullable();
            $table->date('penta1')->nullable();
            $table->date('polio2')->nullable();
            $table->date('pcv1')->nullable();
            $table->date('rotavirus1')->nullable();
            $table->date('penta2')->nullable();
            $table->date('polio3')->nullable();
            $table->date('pcv2')->nullable();
            $table->date('rotavirus2')->nullable();
            $table->date('penta3')->nullable();
            $table->date('polio4')->nullable();
            $table->date('ipv1')->nullable();
            $table->date('rotavirus3')->nullable();
            $table->date('mr1')->nullable();
            $table->date('ipv2')->nullable();
            $table->boolean('lengkap')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idls');
    }
};
