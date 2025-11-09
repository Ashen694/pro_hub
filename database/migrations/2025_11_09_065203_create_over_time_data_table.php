<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('OverTime_Data', function (Blueprint $table) {
            $table->id('ID');
            $table->timestamp('Created_Date')->useCurrent();
            $table->foreignId('Created_By')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('Approval_For');
            $table->unsignedBigInteger('Approved_By')->nullable();
            $table->date('Date');
            $table->decimal('No_Of_Hours', 8, 2);
            $table->text('Work_Description');
            $table->text('Comment')->nullable();
            $table->timestamp('Approved_Date')->nullable();

            // Foreign key constraints for Employee table columns
            $table->foreign('Approval_For')->references('Emp_ID')->on('Employee')->onDelete('cascade');
            $table->foreign('Approved_By')->references('Emp_ID')->on('Employee')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('OverTime_Data');
    }
};