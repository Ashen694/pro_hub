<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalSolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_name',
        'company_customer',
        'developed_by',
        'developed_team',
        'start_date',
        'target_date',
        'dplo_stage',
        'sdlc_stage',
        'percentage_done',
        'bitbucket_repository_name',
        'sales_team_involved',
        'sales_account_manager',
        'sales_manager',
        'sales_engineer',
        'uat_date',
        'launched_date',
        'one_time_charge',
        'monthly_recurring_charge',
        'value_of_software',
        'contract_period_years',
        'support_availability',
        'dpo_handover_date',
        'dpo_handover_comments',
    ];
}
