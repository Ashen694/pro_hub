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
        Schema::create('Document', function (Blueprint $table) {
            $table->bigIncrements('ID'); 
            
            $table->unsignedBigInteger('Platform_ID')->nullable();
            $table->unsignedBigInteger('Solution_ID')->nullable(); 
            $table->string('Doc_Name');
            $table->timestamp('Created_Time')->nullable();
            $table->unsignedBigInteger('Created_By')->nullable(); 
            $table->string('Doc_Type')->nullable();
            $table->string('Doc_classification')->nullable();
            $table->string('Doc_URL'); 
            $table->text('Tags')->nullable();
            $table->string('Confidential')->nullable(); 

         
            $table->foreign('Created_By')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Document');
    }
};