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
        Schema::create('idl_targets', function (Blueprint $table) {
            $table->id();
            $table->integer('sum_boys');
            $table->integer('sum_girls');
            $table->foreignId('village_id')->constrained('villages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idl_targets');
    }
};
