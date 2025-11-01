<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('external_platforms', function (Blueprint $t) {
            $t->id('platform_id');
            $t->string('platform_name', 200);
            $t->string('platform_type', 150)->nullable();
            $t->date('start_date')->nullable();
            $t->date('target_date')->nullable();
            $t->string('developed_by', 200)->nullable();
            $t->string('developed_team', 200)->nullable();
            $t->string('bitbucket', 200)->nullable();
            $t->string('bit_bucket_repo', 300)->nullable();
            $t->string('sdlc_stage', 100)->nullable();
            $t->unsignedTinyInteger('percentage_done')->nullable();
            $t->string('status', 100)->nullable();
            $t->date('status_date')->nullable();
            $t->string('integrated_apps', 300)->nullable();
            $t->string('dr', 150)->nullable();
            $t->unsignedBigInteger('company_id')->nullable();
            $t->unsignedBigInteger('sales_team_id')->nullable();
            $t->string('sales_am', 200)->nullable();
            $t->string('sales_manager', 200)->nullable();
            $t->string('sales_engineer', 200)->nullable();
            $t->date('uat_date')->nullable();
            $t->date('va_date')->nullable();
            $t->date('launched_date')->nullable();
            $t->string('platform_owner', 200)->nullable();
            $t->string('app_op_owner', 200)->nullable();
            $t->string('platform_otc', 100)->nullable();
            $t->string('platform_mrc', 100)->nullable();
            $t->string('contract_period', 100)->nullable();
            $t->string('incentive_earned', 100)->nullable();
            $t->string('incentive_share', 100)->nullable();
            $t->date('billing_date')->nullable();
            $t->string('proposal_upload', 300)->nullable();
            $t->string('sla', 200)->nullable();
            $t->decimal('software_value', 14, 2)->nullable();
            $t->string('backup_officer_1', 200)->nullable();
            $t->string('backup_officer_2', 200)->nullable();
            $t->date('ssl_certificate_exp_date')->nullable();
            $t->string('dpo_handover', 200)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('external_platforms');
    }
};
