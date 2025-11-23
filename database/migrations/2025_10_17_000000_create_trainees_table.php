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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id('Trainee_ID');
            $table->string('Trainee_Name', 255);
            $table->string('Trainee_Phone', 50)->nullable();
            $table->string('Trainee_NIC', 50)->nullable();
            $table->string('Trainee_Email', 255)->nullable();
            $table->date('Training_StartDate')->nullable();
            $table->date('Training_EndDate')->nullable();
            $table->string('Institute', 255)->nullable();
            $table->string('Languages_known', 255)->nullable();
            $table->string('Supervisor', 255)->nullable();
            $table->date('Target_Date')->nullable();
            $table->text('Trainee_HomeAddress')->nullable();
            $table->text('AssignedWork_Description')->nullable();
            $table->string('field_of_specialization', 255)->nullable();
            $table->date('payment_start_date')->nullable();
            $table->date('payment_end_date')->nullable();
            $table->date('requested_payment_date')->nullable();
            $table->integer('absent_Count')->default(0);
            $table->date('terminated_date')->nullable();
            $table->text('terminated_reason')->nullable();
            $table->enum('status', ['active', 'inactive', 'paid'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
