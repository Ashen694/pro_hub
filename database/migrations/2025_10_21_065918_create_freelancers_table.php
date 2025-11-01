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
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
    $table->string('nic');
    $table->string('project_name');
    $table->text('project_scope');
    $table->decimal('total_amount', 12, 2);
    $table->enum('budget_available', ['Yes','No']);
    $table->string('duration');
    $table->date('start_date');
    $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
