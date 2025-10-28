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
        Schema::table('Internal_Platforms', function (Blueprint $table) {
            // Change the 'Status' column to be nullable and remove the default value
            $table->string('Status')->default(null)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internal_platforms', function (Blueprint $table) {
            //
        });
    }
};
