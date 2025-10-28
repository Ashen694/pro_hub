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
        Schema::create('external_solutions', function (Blueprint $table) {
            $table->id();
            $table->string('application_name')->nullable();
            $table->string('company_customer')->nullable();
            $table->string('developed_by')->nullable();
            $table->string('developed_team')->nullable();
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->string('sdlc_stage')->nullable();
            $table->string('percentage_done')->nullable();
            $table->string('bitbucket_repository_name')->nullable();
            $table->string('sales_team_involved')->nullable();
            $table->string('sales_account_manager')->nullable();
            $table->string('sales_manager')->nullable();
            $table->string('sales_engineer')->nullable();
            $table->date('uat_date')->nullable();
            $table->date('launched_date')->nullable();
            $table->decimal('one_time_charge', 12, 2)->nullable();
            $table->decimal('monthly_recurring_charge', 12, 2)->nullable();
            $table->decimal('value_of_software', 14, 2)->nullable();
            $table->integer('contract_period_years')->nullable();
            $table->string('support_availability')->nullable();
            $table->date('dpo_handover_date')->nullable();
            $table->text('dpo_handover_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_solutions');
    }
};
