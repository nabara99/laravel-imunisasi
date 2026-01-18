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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('vaccine_name');
            $table->foreignId('id_category_vaccine')->constrained('vaccine_categories')->onDelete('restrict');
            $table->integer('price');
            $table->string('batch_number');
            $table->date('expired_date');
            $table->integer('stock')->default(0);
            $table->date('date_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
