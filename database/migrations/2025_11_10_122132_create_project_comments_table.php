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
        Schema::create('Project_Comments', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('Activity_ID');
            $table->text('Comment');
            $table->unsignedBigInteger('Updated_By');
            $table->timestamp('Updated_Time')->useCurrent();

            // Foreign Key Constraints
            $table->foreign('Activity_ID')->references('ID')->on('Project_Activities')->onDelete('cascade');
            $table->foreign('Updated_By')->references('Emp_ID')->on('Employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Project_Comments');
    }
};