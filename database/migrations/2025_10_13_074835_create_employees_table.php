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
        Schema::create('Employee', function (Blueprint $table) { 
            $table->id('Emp_ID'); // Primary Key
            $table->string('Emp_Name');
            $table->string('Emp_Email')->unique();
            $table->string('Emp_Phone')->nullable();
            $table->timestamp('LastSuccessfulLogin')->nullable();
            $table->boolean('Locked')->default(false);
            $table->integer('GroupID')->nullable();
            $table->date('DOB')->nullable();
            $table->string('Calling_Name')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Section')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
