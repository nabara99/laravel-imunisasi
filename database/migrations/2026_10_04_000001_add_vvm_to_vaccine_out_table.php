<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vaccine_out', function (Blueprint $table) {
            $table->enum('vvm', ['A', 'B', 'C', 'D'])->nullable()->after('date_out');
        });
    }

    public function down(): void
    {
        Schema::table('vaccine_out', function (Blueprint $table) {
            $table->dropColumn('vvm');
        });
    }
};
