<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_issues', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('Issue_Start_Time');
            $table->unsignedBigInteger('Platform_ID'); 
            $table->string('Reported_By');
            $table->text('Description');
            $table->string('Criticality');
            $table->string('Entered_By');
            $table->string('Assigned_To');
            $table->string('Assigned_By');
            $table->dateTime('Assigned_Time')->nullable();
            $table->string('Status');
            $table->dateTime('Issue_Closed_Time')->nullable();
            $table->string('SLAduration')->nullable();
            $table->boolean('SLAachived')->default(false);
            $table->timestamp('Entered_Time')->useCurrent();
            $table->text('Action_Taken')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_issues');
    }
};