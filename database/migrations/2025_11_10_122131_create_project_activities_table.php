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
        Schema::create('Project_Activities', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('Platform_ID');
            $table->unsignedBigInteger('Solution_ID'); // Assuming this links to internal/external solutions
            $table->text('Description');
            $table->unsignedBigInteger('Created_By');
            $table->timestamp('Created_Time')->useCurrent();
            $table->unsignedBigInteger('Assigned_To');
            $table->date('Target_Date');
            $table->string('Status')->default('Pending');
            $table->unsignedBigInteger('Updated_By')->nullable();
            $table->timestamp('Updated_Date')->nullable();

            // Foreign Key Constraints
            $table->foreign('Platform_ID')->references('ID')->on('Main_Platforms')->onDelete('cascade');
            $table->foreign('Created_By')->references('Emp_ID')->on('Employee')->onDelete('cascade');
            $table->foreign('Assigned_To')->references('Emp_ID')->on('Employee')->onDelete('cascade');
            $table->foreign('Updated_By')->references('Emp_ID')->on('Employee')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Project_Activities');
    }
};