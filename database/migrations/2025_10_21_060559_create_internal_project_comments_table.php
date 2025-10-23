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
        Schema::create('Internal_Project_Comments', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('Solution_ID');
            $table->text('Comment')->nullable();
            $table->string('Updated_By')->nullable(); // Employee name or ID
            $table->timestamp('Updated_Time')->useCurrent();
            $table->timestamps();

            $table->foreign('Solution_ID')->references('ID')->on('Internal_Platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_project_comments');
    }
};
