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
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable()->after('is_active'); // Define the new city_id column
            $table->foreign('city_id')->references('id')->on('cities'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id'); 
        });
    }
};
